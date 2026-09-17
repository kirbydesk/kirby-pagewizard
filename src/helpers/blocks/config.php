<?php

class pwConfig
{
	private static array $configPaths = [];
	private static ?array $projectConfig = null;
	/** @deprecated — font generation now checks $imports directly */
	private static bool $fontsGenerated = false;
	private static bool $panelColorsGenerated = false;

	/* ============================================================
	   I/O helpers — the single place other classes (e.g. ProjectConfig)
	   should go through when reading pagewizard-owned config files.
	   ============================================================ */

	/**
	 * Read + json_decode a file, returning the decoded array or a
	 * caller-provided default when the file is missing or invalid JSON.
	 */
	public static function readJson(string $path, array $default = []): array
	{
		if (!file_exists($path)) return $default;
		$decoded = json_decode(file_get_contents($path), true);
		return is_array($decoded) ? $decoded : $default;
	}

	/**
	 * Read a JSON file from the kirby-pagewizard plugin's /config directory.
	 * Example: pluginConfig('navigation') → <plugin>/config/navigation.json
	 */
	public static function pluginConfig(string $name, array $default = []): array
	{
		return self::readJson(self::pluginDir() . '/config/' . $name . '.json', $default);
	}

	/**
	 * Read a JSON file from the project's projectwizard override directory.
	 * Example: projectOverride('navigation') → content/.projectwizard/navigation.json
	 */
	public static function projectOverride(string $name, array $default = []): array
	{
		return self::readJson(self::projectDir() . '/' . $name . '.json', $default);
	}

	/**
	 * Path to the kirby-pagewizard plugin directory. Cached to avoid
	 * repeated Kirby::plugin() lookups within a request.
	 */
	public static function pluginDir(): string
	{
		static $cached = null;
		if ($cached !== null) return $cached;
		return $cached = kirby()->plugin('kirbydesk/kirby-pagewizard')->root();
	}

	/**
	 * Path to the project's projectwizard override directory. Panel-edited
	 * JSON configs (blocks, overrides, global, navigation, footer,
	 * elements, fontsizes, fonts, per-block values) live here.
	 *
	 * Location: content/.projectwizard/ — deliberately inside the content
	 * folder so panel edits (design, colors, block visibility etc. that
	 * the editor makes) travel with the content deploy, not the code deploy.
	 */
	public static function projectDir(): string
	{
		return kirby()->root('content') . '/.projectwizard';
	}

	/**
	 * Read projectwizard config directly from JSON files.
	 * Replaces the old option('kirbydesk.pagewizard') approach.
	 */
	public static function projectConfig(?string $key = null)
	{
		if (self::$projectConfig === null) {
			self::$projectConfig = [
				'blocks'       => self::projectOverride('blocks')['blocks'] ?? [],
				'kirbyblocks'  => self::projectOverride('overrides'),
			];
		}

		if ($key === null) return self::$projectConfig;

		// Support dot notation: 'kirbyblocks.pwhero'
		$parts = explode('.', $key);
		$val = self::$projectConfig;
		foreach ($parts as $part) {
			if (!is_array($val) || !array_key_exists($part, $val)) return [];
			$val = $val[$part];
		}
		return $val;
	}

	/**
	 * Flatten navigation.json into a simple key→value array, merged with projectwizard overrides.
	 * Used by snippets (header.php, logo.php) to read nav config values.
	 */
	public static function navConfig(): array
	{
		static $cache = null;
		if ($cache !== null) return $cache;

		$nav       = self::pluginConfig('navigation');
		$overrides = self::projectOverride('navigation')['global'] ?? [];

		$flat = [];
		foreach ($nav as $group) {
			if (!is_array($group) || !isset($group['vars'])) continue;
			foreach ($group['vars'] as $varName => $def) {
				if (($def['type'] ?? null) === 'label') continue;
				// Color-group: extract sub-fields
				if (in_array($def['type'] ?? null, ['color-pair', 'color-group']) && isset($def['fields'])) {
					foreach ($def['fields'] as $fieldName => $fieldDef) {
						$flat[$fieldName] = $overrides[$fieldName] ?? $fieldDef['value'] ?? '';
					}
					continue;
				}
				// Responsive (default/lg/xl): use default breakpoint
				if (is_array($def) && isset($def['default']) && isset($def['lg']) && !isset($def['variant'])) {
					$flat[$varName] = $overrides['default'][$varName] ?? $def['default'];
					continue;
				}
				$defaultVal = is_array($def) ? ($def['value'] ?? '') : $def;
				$flat[$varName] = $overrides[$varName] ?? $defaultVal;
			}
		}

		$cache = $flat;
		return $flat;
	}

	/**
	 * Flatten footer.json into a simple key→value array, merged with projectwizard overrides.
	 * Mirrors navConfig() for the footer config so snippets can read footer-* values directly.
	 */
	public static function footerConfig(): array
	{
		static $cache = null;
		if ($cache !== null) return $cache;

		$footer    = self::pluginConfig('footer');
		$overrides = self::projectOverride('footer')['global'] ?? [];

		$flat = [];
		foreach ($footer as $group) {
			if (!is_array($group) || !isset($group['vars'])) continue;
			foreach ($group['vars'] as $varName => $def) {
				$defaultVal = is_array($def) ? ($def['value'] ?? '') : $def;
				$flat[$varName] = $overrides[$varName] ?? $defaultVal;
			}
		}

		$cache = $flat;
		return $flat;
	}

	/**
	 * Register a block type's config directory (call from plugin index.php).
	 */
	public static function register(string $blockType, string $configDir): void
	{
		self::$configPaths[$blockType] = $configDir;
	}

	/**
	 * Return all registered block types as [blockType => configDir].
	 * Lets the projectwizard discover blocks regardless of their plugin
	 * folder name (kirbyblock-*, site-*, custom-*, …).
	 */
	public static function registered(): array
	{
		return self::$configPaths;
	}

	/**
	 * Load per-block CSS-variable definitions ('values' section in settings.json)
	 * plus any user-edited overrides from content/.projectwizard/<blockType>.json.
	 *
	 * Returns ['defaults' => [...], 'overrides' => [...]] where defaults follows
	 * the same shape as global.json (groups → vars), and overrides is a flat
	 * map { varName: value, … }.
	 */
	public static function loadValues(string $blockType): array
	{
		$configDir = self::$configPaths[$blockType] ?? null;
		if ($configDir === null) return ['defaults' => [], 'overrides' => []];

		$defaults = [];
		$defaults  = self::readJson($configDir . '/settings.json')['values'] ?? [];
		$overrides = self::projectOverride($blockType);

		return ['defaults' => $defaults, 'overrides' => $overrides];
	}

	/**
	 * Load settings and defaults from settings.json, merged with config.php overrides.
	 * Defaults are extracted from the object format in settings.json (no separate defaults.json).
	 */
	public static function load(string $blockType): array
	{
		$configDir = self::$configPaths[$blockType] ?? null;

		if ($configDir === null) {
			return ['content' => [], 'tabs' => [], 'defaults' => [], 'fields' => [], 'editor' => [], 'layout' => [], 'style' => [], 'effects' => [], 'settings' => [], 'field-options' => []];
		}

		/* -------------- Block Settings (merged source for toggles + defaults) --------------*/
		$settingsRaw = self::readJson($configDir . '/settings.json');

		$tabSettings = $settingsRaw['tabs'] ?? [];

		$fieldsRaw   = $settingsRaw['fields'] ?? [];
		$rawContent  = $fieldsRaw['content']  ?? [];
		$layoutVis   = $fieldsRaw['layout']   ?? [];
		$styleVis    = $fieldsRaw['style']    ?? [];
		$gridVis     = $fieldsRaw['grid']     ?? [];
		$effectsVis  = $fieldsRaw['effects']  ?? [];
		$settingsVis = $fieldsRaw['settings'] ?? [];

		[$settings, $fieldOptions] = self::parseContentSettings($rawContent);
		$fields = self::extractContentDefaults($rawContent);

		$defaults = array_merge(
			self::extractCategoryDefaults($layoutVis),
			self::extractCategoryDefaults($styleVis),
			self::extractCategoryDefaults($gridVis),
			self::extractCategoryDefaults($settingsVis),
			self::extractCategoryDefaults($effectsVis)
		);

		/* -------------- Optional defaults block (pre-projectwizard style) ---------*/
		// Plugins that use the older content/layout/style/grid/settings/effects
		// defaults shape can carry it under settings.json's top-level "defaults" key.
		$legacyDefaults = $settingsRaw['defaults'] ?? null;
		if (is_array($legacyDefaults)) {
			// Content section: { heading: { align: "left", level: "h2" } } → fields[align-heading], fields[level-heading]
			foreach ($legacyDefaults['content'] ?? [] as $fieldKey => $props) {
				if (!is_array($props)) {
					$fields[$fieldKey] = $fields[$fieldKey] ?? $props;
					continue;
				}
				foreach ($props as $prop => $val) {
					$flatProp = ($prop === 'sizes') ? 'size' : $prop;
					$key = $flatProp . '-' . $fieldKey;
					if (!array_key_exists($key, $fields)) {
						$fields[$key] = $val;
					}
				}
			}

			// Categories: { layout: { padding-top: true } } → defaults[padding-top]
			foreach (['layout', 'style', 'grid', 'settings', 'effects'] as $cat) {
				foreach ($legacyDefaults[$cat] ?? [] as $key => $val) {
					if (!array_key_exists($key, $defaults)) {
						$defaults[$key] = $val;
					}
				}
			}
		}

		/* -------------- Editor config --------------*/
		$editor = self::readJson($configDir . '/editor.json');

		/* -------------- Config overrides from config.php --------------*/
		$raw = self::projectConfig("kirbyblocks.{$blockType}");
		$cfg = is_array($raw) ? $raw : [];

		// Overrides live under $cfg['settings'] — one wrapped format only.
		$cfgVis = (!empty($cfg['settings']) && is_array($cfg['settings'])) ? $cfg['settings'] : [];

		// tabs
		if (!empty($cfgVis['tabs']) && is_array($cfgVis['tabs'])) {
			$tabSettings = array_merge($tabSettings, $cfgVis['tabs']);
		}
		// fields: nested { content: {}, layout: {}, style: {}, settings: {} }
		if (!empty($cfgVis['fields']) && is_array($cfgVis['fields'])) {
			if (!empty($cfgVis['fields']['content'])) {
				[$cfgSettings, $cfgFieldOptions] = self::parseContentSettings($cfgVis['fields']['content']);
				$settings     = array_merge($settings,     $cfgSettings);
				// Deep merge fieldOptions so individual properties are overridden, not entire field entries
				foreach ($cfgFieldOptions as $fk => $fv) {
					if (isset($fieldOptions[$fk]) && is_array($fieldOptions[$fk]) && is_array($fv)) {
						$fieldOptions[$fk] = array_merge($fieldOptions[$fk], $fv);
					} else {
						$fieldOptions[$fk] = $fv;
					}
				}
				$fields       = array_merge($fields, self::extractContentDefaults($cfgVis['fields']['content']));
			}
			// Per-field shallow merge: overrides typically carry only the changed
			// property (e.g. { default: 'foo' }); a plain array_merge at this level
			// would replace the whole field def and drop the plugin's options/type/
			// labels/SVGs. Merge per field so override keys win and the rest survives.
			$mergeFields = function (array $base, array $overrides): array {
				foreach ($overrides as $fieldKey => $override) {
					if (isset($base[$fieldKey]) && is_array($base[$fieldKey]) && is_array($override)) {
						$base[$fieldKey] = array_merge($base[$fieldKey], $override);
					} else {
						$base[$fieldKey] = $override;
					}
				}
				return $base;
			};
			if (!empty($cfgVis['fields']['layout']))   $layoutVis   = $mergeFields($layoutVis,   $cfgVis['fields']['layout']);
			if (!empty($cfgVis['fields']['style']))    $styleVis    = $mergeFields($styleVis,    $cfgVis['fields']['style']);
			if (!empty($cfgVis['fields']['grid']))     $gridVis     = $mergeFields($gridVis,     $cfgVis['fields']['grid']);
			if (!empty($cfgVis['fields']['effects']))  $effectsVis  = $mergeFields($effectsVis,  $cfgVis['fields']['effects']);
			if (!empty($cfgVis['fields']['settings'])) $settingsVis = $mergeFields($settingsVis, $cfgVis['fields']['settings']);

			// Re-extract category defaults so per-field default overrides
			// (e.g. settings.fields.layout.padding-top.default = 'small')
			// actually replace the plugin defaults populated earlier.
			$defaults = array_merge(
				$defaults,
				self::extractCategoryDefaults($layoutVis),
				self::extractCategoryDefaults($styleVis),
				self::extractCategoryDefaults($gridVis),
				self::extractCategoryDefaults($settingsVis),
				self::extractCategoryDefaults($effectsVis)
			);
		}
		// defaults overrides — nested by category (content/layout/style/grid/settings/effects)
		if (!empty($cfgVis['defaults']) && is_array($cfgVis['defaults'])) {
			$flatOverrides = array_merge(
				$cfgVis['defaults']['layout']   ?? [],
				$cfgVis['defaults']['style']    ?? [],
				$cfgVis['defaults']['grid']     ?? [],
				$cfgVis['defaults']['settings'] ?? [],
				$cfgVis['defaults']['effects']  ?? []
			);
			$defaults = array_merge($defaults, $flatOverrides);
			if (!empty($cfgVis['defaults']['content'])) {
				$fields = array_merge($fields, self::flattenContentDefaults($cfgVis['defaults']['content']));
			}
		}
		if (!empty($cfgVis['editor']) && is_array($cfgVis['editor'])) {
			foreach ($cfgVis['editor'] as $key => $value) {
				if (is_array($value) && isset($editor[$key]) && is_array($editor[$key])) {
					$editor[$key] = array_merge($editor[$key], $value);
				} else {
					$editor[$key] = $value;
				}
			}
		}

		return [
			'content'      => $settings,
			'tabs'         => $tabSettings,
			'defaults'     => $defaults,
			'fields'       => $fields,
			'editor'       => $editor,
			'layout'       => $layoutVis,
			'style'        => $styleVis,
			'effects'      => $effectsVis,
			'settings'     => $settingsVis,
			'field-options' => $fieldOptions,
		];
	}

	/**
	 * Extract default values from content field objects in settings.json.
	 * Nested: { "heading": { "align": { "options": [...], "default": "left" } } } → { "align-heading": "left" }
	 * Simple: { "item-radius-top-left": { "default": false } } → { "item-radius-top-left": false }
	 * Maps "sizes" → "size" for backward compatibility.
	 */
	private static function extractContentDefaults(array $rawContent): array
	{
		$fields = [];
		foreach ($rawContent as $fieldKey => $fieldValue) {
			if (!is_array($fieldValue) || array_is_list($fieldValue)) continue;

			// Check if field has nested property objects
			$hasNestedProps = false;
			foreach ($fieldValue as $propValue) {
				if (is_array($propValue) && (isset($propValue['default']) || isset($propValue['options']))) {
					$hasNestedProps = true;
					break;
				}
			}

			if ($hasNestedProps) {
				// Nested: extract default from each property
				foreach ($fieldValue as $prop => $propValue) {
					if (is_array($propValue) && isset($propValue['default'])) {
						$flatProp = ($prop === 'sizes') ? 'size' : $prop;
						$fields["{$flatProp}-{$fieldKey}"] = $propValue['default'];
					}
				}
			} elseif (isset($fieldValue['default'])) {
				// Simple field with just a default value
				$fields[$fieldKey] = $fieldValue['default'];
			}
		}
		return $fields;
	}

	/**
	 * Extract default values from category field definitions (layout, style, grid, settings, effects).
	 * { "padding-top": { "default": "large" }, "theme": { "options": [...], "default": "default" } }
	 * → { "padding-top": "large", "theme": "default" }
	 * Skips "enabled" strings and plain booleans (visibility toggles, no defaults).
	 */
	private static function extractCategoryDefaults(array $categoryFields): array
	{
		$defaults = [];
		foreach ($categoryFields as $key => $value) {
			if (is_array($value) && isset($value['default'])) {
				$defaults[$key] = $value['default'];
			}
		}
		return $defaults;
	}

	/**
	 * Parse settings.json fields.content into $settings (content toggles) and $fieldOptions (available options).
	 * "enabled" → settings[field]=true
	 * { "align": { "options": [...] }, "mode": { "options": [...] } } → settings[field]=mode_options, fieldOptions[field]={...}
	 * { "default": ... } → skipped (default-only field, handled by extractContentDefaults)
	 * Plain array → settings[field]=array (special cases like column-blocks)
	 */
	private static function parseContentSettings(array $raw): array
	{
		$settings     = [];
		$fieldOptions = [];
		foreach ($raw as $fieldKey => $fieldValue) {
			// Disabled field
			if (is_array($fieldValue) && !empty($fieldValue['_disabled'])) {
				$settings[$fieldKey] = false;
				continue;
			}
			if ($fieldValue === false) {
				$settings[$fieldKey] = false;
				continue;
			}
			if ($fieldValue === 'enabled') {
				$settings[$fieldKey] = true;
			} elseif (is_array($fieldValue) && !array_is_list($fieldValue)) {
				// Check if this is a default-only field (no configurable properties)
				$hasNestedProps = false;
				foreach ($fieldValue as $propValue) {
					if (is_array($propValue) && (isset($propValue['options']) || isset($propValue['default']))) {
						$hasNestedProps = true;
						break;
					}
					if ($propValue === false) {
						$hasNestedProps = true;
						break;
					}
				}

				if (!$hasNestedProps && isset($fieldValue['default'])) {
					// Default-only field — don't add to settings
					continue;
				}

				// Field with configurable properties
				$opts = [];
				$mode = true;

				foreach ($fieldValue as $prop => $propValue) {
					if (is_array($propValue) && isset($propValue['options'])) {
						$opts[$prop] = $propValue['options'];
						if ($prop === 'mode') {
							$mode = $propValue['options'];
						}
					} elseif (is_array($propValue) && array_is_list($propValue)) {
						$opts[$prop] = $propValue;
						if ($prop === 'mode') {
							$mode = $propValue;
						}
					} elseif ($propValue === false) {
						$opts[$prop] = false;
					}
				}

				$settings[$fieldKey] = $mode;
				if (!empty($opts)) {
					$fieldOptions[$fieldKey] = $opts;
				}
			} else {
				// Plain array (e.g., column-blocks) or boolean
				$settings[$fieldKey] = $fieldValue;
				if (is_array($fieldValue)) {
					$fieldOptions[$fieldKey] = ['mode' => $fieldValue];
				}
			}
		}
		return [$settings, $fieldOptions];
	}

	/**
	 * Flatten nested content defaults (legacy format for config.php overrides).
	 * { "heading": {"align":"left","size":"2xl"} } → { "align-heading":"left", "size-heading":"2xl" }
	 */
	private static function flattenContentDefaults(array $raw): array
	{
		$fields = [];
		foreach ($raw as $fieldKey => $fieldValue) {
			if (is_array($fieldValue)) {
				foreach ($fieldValue as $prop => $val) {
					$fields["{$prop}-{$fieldKey}"] = $val;
				}
			} else {
				$fields[$fieldKey] = $fieldValue;
			}
		}
		return $fields;
	}

	/**
	 * Get settings for a block type.
	 */
	public static function settings(string $blockType): array
	{
		return self::load($blockType)['content'];
	}

	/**
	 * Add a tab or, if disabled, inject its fields as hidden fields into the content tab.
	 */
	public static function addTab(array &$tabs, string $tabKey, bool $enabled, array $tabOptions): void
	{
		if ($enabled) {
			$tabs[$tabKey] = $tabOptions;
		} else {
			foreach ($tabOptions['fields'] as $key => $field) {
				if (array_key_exists('default', $field)) {
					$tabs['content']['fields'] += [$key => ['type' => 'hidden', 'default' => $field['default']]];
				}
			}
		}
	}

	/**
	 * Called by projectbuilder-hook for plugin-specific CSS var injection and stub creation.
	 * Reads navigation.json, navigation-colors.json, colors.json, merges with project overrides,
	 * appends :root { ... } to $imports, and creates config/sprites stubs.
	 */
	public static function tailwindSetup(string $pluginDir, array &$imports): void
	{
		$patchConfigDir = kirby()->root('site') . '/patches/config';
		if (!is_dir($patchConfigDir)) mkdir($patchConfigDir, 0777, true);

		// Fonts: load early so all sections can reference them for font-family lookups.
		// Reads the plugin's own config/fonts.json (only pagewizard actually has one —
		// for other plugins in the loop, this is intentionally empty).
		$builtinFonts = self::readJson($pluginDir . '/config/fonts.json');
		$projectFonts = self::projectOverride('fonts');
		unset($projectFonts['_default']);
		$allFonts = array_merge($builtinFonts, $projectFonts);

		// Resolve body default font (always reads pagewizard's global.json).
		$globalData = self::pluginConfig('global');
		$globalOv   = self::projectOverride('global');
		$bodyDefaultFont = $globalOv['global']['font-family-default']
			?? $globalData['body']['vars']['font-family-default']['value']
			?? 'Inter';

		// Navigation: read the plugin's own config/navigation.json (plugin-local).
		$nav          = self::readJson($pluginDir . '/config/navigation.json');
		$navOverrides = self::projectOverride('navigation');

		$rootLines = [];
		$navLinesLg = [];
		$navLinesXl = [];
		foreach ($nav as $groupKey => $group) {
			if (!is_array($group) || !isset($group['vars'])) continue;
			foreach ($group['vars'] as $varName => $def) {
				// Skip non-CSS types (rendered in PHP snippets, not via CSS variables)
				$type = $def['type'] ?? null;
				if (in_array($type, ['label', 'svg', 'visibility', 'icon-select', 'config'])) continue;
				// Skip SVG dimension fields
				if (str_ends_with($varName, '-src-width') || str_ends_with($varName, '-src-height')) continue;

				// Responsive font-size (default/lg/xl) — legacy format
				if (is_array($def) && isset($def['default']) && isset($def['lg']) && !isset($def['variant']) && !isset($def['breakpoint'])) {
					foreach (['default' => &$rootLines, 'lg' => &$navLinesLg, 'xl' => &$navLinesXl] as $bp => &$lines) {
						$override = ($navOverrides['global'][$bp][$varName] ?? null);
						$lines[] = "\t--nav-" . $varName . ': ' . ($override ?? $def[$bp]) . ';';
					}
					unset($lines);
					continue;
				}
				// Breakpoint-specific field (e.g. desktop-font-size → --nav-font-size at xl)
				if (isset($def['breakpoint'])) {
					$bp = $def['breakpoint'];
					$cssName = preg_replace('/^(desktop|tablet|mobile)-/', '', $varName);
					$override = ($navOverrides['global'][$varName] ?? null);
					$val = $override ?? ($def['value'] ?? '');
					$target = $bp === 'lg' ? $navLinesLg : ($bp === 'xl' ? $navLinesXl : $rootLines);
					if ($bp === 'lg') { $navLinesLg[] = "\t--nav-" . $cssName . ': ' . $val . ';'; }
					elseif ($bp === 'xl') { $navLinesXl[] = "\t--nav-" . $cssName . ': ' . $val . ';'; }
					else { $rootLines[] = "\t--nav-" . $cssName . ': ' . $val . ';'; }
					continue;
				}
				$defaultVal = is_array($def) ? ($def['value'] ?? '') : $def;
				$override = ($navOverrides['global'][$varName] ?? null);
				if (($def['type'] ?? null) === 'font-family') {
					$fontVal = $override ?? $defaultVal;
					if ($fontVal === 'default') $fontVal = $bodyDefaultFont;
					$fontCategory = 'sans-serif';
					foreach ($allFonts as $f) {
						if ($f['family'] === $fontVal) {
							$fontCategory = $f['category'] ?? 'sans-serif';
							break;
						}
					}
					$rootLines[] = "\t--nav-" . $varName . ": '" . $fontVal . "', " . $fontCategory . ';';
				} elseif (in_array($def['type'] ?? null, ['color-pair', 'color-group']) && isset($def['fields'])) {
					foreach ($def['fields'] as $fieldName => $fieldDef) {
						$fieldDefault = $fieldDef['value'] ?? '';
						$fieldOverride = ($navOverrides['global'][$fieldName] ?? null);
						$rootLines[] = "\t--nav-" . $fieldName . ': ' . ($fieldOverride ?? $fieldDefault) . ';';
					}
				} elseif (is_array($defaultVal)) {
					$vals = is_array($override) ? $override : $defaultVal;
					$rootLines[] = "\t--nav-" . $varName . ': ' . implode(' ', $vals) . ';';
				} else {
					$rootLines[] = "\t--nav-" . $varName . ': ' . ($override ?? $defaultVal) . ';';
				}
			}
		}
		if (!empty($rootLines)) {
			$imports[] = ":root {\n" . implode("\n", $rootLines) . "\n}";
		}
		if (!empty($navLinesLg)) {
			$imports[] = "@media (min-width: 1024px) {\n:root {\n" . implode("\n", $navLinesLg) . "\n}\n}";
		}
		if (!empty($navLinesXl)) {
			$imports[] = "@media (min-width: 1280px) {\n:root {\n" . implode("\n", $navLinesXl) . "\n}\n}";
		}

		// Global: reuse already-loaded global.json data
		$global = $globalData;
		$globalOverrides = $globalOv;

		$globalLines = [];
		foreach ($global as $groupKey => $group) {
			if (!is_array($group)) continue;
			// Style vars (single values)
			if (isset($group['vars'])) {
				foreach ($group['vars'] as $varName => $def) {
					$defaultVal = is_array($def) ? ($def['value'] ?? '') : $def;
					// Array with suffixes: generate separate variables per value
					if (is_array($defaultVal) && isset($def['suffixes'])) {
						$override = ($globalOverrides['global'][$varName] ?? null);
						$vals = is_array($override) ? $override : $defaultVal;
						foreach ($def['suffixes'] as $i => $suffix) {
							$globalLines[] = "\t--" . $varName . $suffix . ': ' . ($vals[$i] ?? '') . ';';
						}
					} elseif (is_array($defaultVal)) {
						$override = ($globalOverrides['global'][$varName] ?? null);
						$vals = is_array($override) ? $override : $defaultVal;
						$globalLines[] = "\t--" . $varName . ': ' . implode(' ', $vals) . ';';
					} elseif (($def['type'] ?? null) === 'font-family') {
						$override = ($globalOverrides['global'][$varName] ?? null);
						$fontVal = $override ?? $defaultVal;
						if ($fontVal === 'default') $fontVal = $bodyDefaultFont;
						$fontCategory = 'sans-serif';
						foreach ($allFonts as $f) {
							if ($f['family'] === $fontVal) {
								$fontCategory = $f['category'] ?? 'sans-serif';
								break;
							}
						}
						$globalLines[] = "\t--" . $varName . ": '" . $fontVal . "', " . $fontCategory . ';';
					} else {
						$override = ($globalOverrides['global'][$varName] ?? null);
						$globalLines[] = "\t--" . $varName . ': ' . ($override ?? $defaultVal) . ';';
					}
				}
			}
			// Color vars (multi-theme)
			if (isset($group['colors'])) {
				foreach ($group['colors'] as $varName => $value) {
					foreach ($value as $theme => $themeValue) {
						$override = ($globalOverrides['global'][$theme][$varName] ?? null);
						$suffix = $theme === 'default' ? '' : '-' . $theme;
						$globalLines[] = "\t--" . $varName . $suffix . ': ' . ($override ?? $themeValue) . ';';
					}
				}
			}
		}
		if (!empty($globalLines)) {
			$imports[] = ":root {\n" . implode("\n", $globalLines) . "\n}";
		}

		// Font sizes: read the plugin's own config/fontsizes.json (plugin-local).
		$fonts         = self::readJson($pluginDir . '/config/fontsizes.json');
		$fontOverrides = self::projectOverride('fontsizes');

		$breakpoints = [
			'default' => null,
			'lg' => '(min-width: 1024px)',
			'xl' => '(min-width: 1280px)',
		];

		foreach ($breakpoints as $bp => $mediaQuery) {
			$bpLines = [];
			foreach ($fonts as $groupKey => $group) {
				if (!is_array($group) || !isset($group['vars'])) continue;
				foreach ($group['vars'] as $varName => $value) {
					$defaultVal = $value[$bp] ?? null;
					if ($defaultVal === null) continue;
					$override = ($fontOverrides['global'][$bp][$varName] ?? null);
					$bpLines[] = "\t--" . $varName . ': ' . ($override ?? $defaultVal) . ';';
				}
			}
			if (!empty($bpLines)) {
				$rootBlock = ":root {\n" . implode("\n", $bpLines) . "\n}";
				if ($mediaQuery) {
					$imports[] = "@media " . $mediaQuery . " {\n" . $rootBlock . "\n}";
				} else {
					$imports[] = $rootBlock;
				}
			}
		}

		// Elements: read the plugin's own config/elements.json (plugin-local).
		$elements         = self::readJson($pluginDir . '/config/elements.json');
		$elementOverrides = self::projectOverride('elements');

		$elementLines = [];
		$elementLinesLg = [];
		$elementLinesXl = [];
		foreach ($elements as $groupKey => $group) {
			if (!is_array($group)) continue;
			// Style vars (single values)
			if (isset($group['vars'])) {
				foreach ($group['vars'] as $varName => $def) {
					// Responsive font-size (default/lg/xl)
					if (is_array($def) && isset($def['default']) && isset($def['lg']) && !isset($def['variant'])) {
						foreach (['default' => &$elementLines, 'lg' => &$elementLinesLg, 'xl' => &$elementLinesXl] as $bp => &$lines) {
							$override = ($elementOverrides['global'][$bp][$varName] ?? null);
							$lines[] = "\t--" . $varName . ': ' . ($override ?? $def[$bp]) . ';';
						}
						unset($lines);
						continue;
					}
					$defaultVal = is_array($def) ? ($def['value'] ?? '') : $def;
					// Array with suffixes: generate separate variables per value
					if (is_array($defaultVal) && isset($def['suffixes'])) {
						$override = ($elementOverrides['global'][$varName] ?? null);
						$vals = is_array($override) ? $override : $defaultVal;
						foreach ($def['suffixes'] as $i => $suffix) {
							$elementLines[] = "\t--" . $varName . $suffix . ': ' . ($vals[$i] ?? '') . ';';
						}
					// Quad values: array of 4 values → join as shorthand
					} elseif (is_array($defaultVal)) {
						$override = ($elementOverrides['global'][$varName] ?? null);
						$vals = is_array($override) ? $override : $defaultVal;
						$elementLines[] = "\t--" . $varName . ': ' . implode(' ', $vals) . ';';
					} elseif (($def['type'] ?? null) === 'font-family') {
						$override = ($elementOverrides['global'][$varName] ?? null);
						$fontVal = $override ?? $defaultVal;
						if ($fontVal === 'default') $fontVal = $bodyDefaultFont;
						$fontCategory = 'sans-serif';
						foreach ($allFonts as $f) {
							if ($f['family'] === $fontVal) {
								$fontCategory = $f['category'] ?? 'sans-serif';
								break;
							}
						}
						$elementLines[] = "\t--" . $varName . ": '" . $fontVal . "', " . $fontCategory . ';';
					} elseif (($def['type'] ?? null) === 'toggle-pair' && isset($def['generates'])) {
						// Toggle that generates multiple CSS variables
						$override = ($elementOverrides['global'][$varName] ?? null);
						$state = $override ?? $defaultVal;
						foreach ($def['generates'] as $genVar => $mapping) {
							$elementLines[] = "\t--" . $genVar . ': ' . ($mapping[$state] ?? '') . ';';
						}
					} else {
						$override = ($elementOverrides['global'][$varName] ?? null);
						$elementLines[] = "\t--" . $varName . ': ' . ($override ?? $defaultVal) . ';';
					}
				}
			}
			// Color vars (multi-theme: default, variant, variant2)
			if (isset($group['colors'])) {
				foreach ($group['colors'] as $varName => $value) {
					foreach ($value as $theme => $themeValue) {
						$override = ($elementOverrides['global'][$theme][$varName] ?? null);
						$suffix = $theme === 'default' ? '' : '-' . $theme;
						$elementLines[] = "\t--" . $varName . $suffix . ': ' . ($override ?? $themeValue) . ';';
					}
				}
			}
		}
		if (!empty($elementLines)) {
			$imports[] = ":root {\n" . implode("\n", $elementLines) . "\n}";
		}
		if (!empty($elementLinesLg)) {
			$imports[] = "@media (min-width: 1024px) {\n:root {\n" . implode("\n", $elementLinesLg) . "\n}\n}";
		}
		if (!empty($elementLinesXl)) {
			$imports[] = "@media (min-width: 1280px) {\n:root {\n" . implode("\n", $elementLinesXl) . "\n}\n}";
		}

		// Footer: read the plugin's own config/footer.json (plugin-local).
		$footer          = self::readJson($pluginDir . '/config/footer.json');
		$footerOverrides = self::projectOverride('footer');

		$footerLines = [];
		foreach ($footer as $groupKey => $group) {
			if (!is_array($group) || !isset($group['vars'])) continue;
			foreach ($group['vars'] as $varName => $def) {
				$defaultVal = is_array($def) ? ($def['value'] ?? '') : $def;
				$override = ($footerOverrides['global'][$varName] ?? null);
				if (is_array($defaultVal) && isset($def['suffixes'])) {
					$vals = is_array($override) ? $override : $defaultVal;
					foreach ($def['suffixes'] as $i => $suffix) {
						$footerLines[] = "\t--" . $varName . $suffix . ': ' . ($vals[$i] ?? '') . ';';
					}
				} elseif (is_array($defaultVal)) {
					$vals = is_array($override) ? $override : $defaultVal;
					$footerLines[] = "\t--" . $varName . ': ' . implode(' ', $vals) . ';';
				} elseif (($def['type'] ?? null) === 'font-family') {
					$fontVal = $override ?? $defaultVal;
					if ($fontVal === 'default') $fontVal = $bodyDefaultFont;
					$fontCategory = 'sans-serif';
					foreach ($allFonts as $f) {
						if ($f['family'] === $fontVal) {
							$fontCategory = $f['category'] ?? 'sans-serif';
							break;
						}
					}
					$footerLines[] = "\t--" . $varName . ": '" . $fontVal . "', " . $fontCategory . ';';
				} else {
					$footerLines[] = "\t--" . $varName . ': ' . ($override ?? $defaultVal) . ';';
				}
			}
		}
		if (!empty($footerLines)) {
			$imports[] = ":root {\n" . implode("\n", $footerLines) . "\n}";
		}

		// Fonts: generate @font-face rules, copy files
		$fontsDir = kirby()->root('index') . '/assets/fonts';
		if (!is_dir($fontsDir)) mkdir($fontsDir, 0777, true);

		// Copy builtin font files to public/assets/fonts/
		foreach ($builtinFonts as $font) {
			if (!($font['builtin'] ?? false)) continue;
			foreach ($font['files'] ?? [] as $file) {
				$src = $pluginDir . '/assets/fonts/' . $file['src'];
				$dst = $fontsDir . '/' . $file['src'];
				if (file_exists($src) && !file_exists($dst)) {
					copy($src, $dst);
				}
			}
		}

		// Generate @font-face rules (only once, not per plugin call)
		$hasExistingFontFace = false;
		foreach ($imports as $entry) {
			if (str_contains($entry, '@font-face')) { $hasExistingFontFace = true; break; }
		}
		if (!$hasExistingFontFace) {
			foreach ($allFonts as $font) {
				$autoItalic = !empty($font['italic']) && count($font['files'] ?? []) === 1;
				foreach ($font['files'] ?? [] as $file) {
					$styles = $autoItalic ? ['normal', 'italic'] : [$file['style'] ?? 'normal'];
					foreach ($styles as $style) {
						$fontFace = "@font-face {\n";
						$fontFace .= "\tfont-display: swap;\n";
						$fontFace .= "\tfont-family: '" . $font['family'] . "';\n";
						$fontFace .= "\tfont-style: " . $style . ";\n";
						$fontFace .= "\tfont-weight: " . ($file['weight'] ?? '400') . ";\n";
						$fontFace .= "\tsrc: url('/assets/fonts/" . $file['src'] . "') format('woff2');\n";
						$fontFace .= "}";
						$imports[] = $fontFace;
					}
				}
			}
		}

		// Per-block CSS variables (each plugin's settings.json 'values' section,
		// merged with content/.projectwizard/<blockType>.json overrides).
		// Each variable becomes --<blockType>-<varName>[suffix]: value;
		// Rendered for every tailwindSetup() call. Duplicate :root {} blocks
		// across multiple hook invocations in the same request (e.g. language
		// redirect fires route:after twice) are harmless — Tailwind's build
		// consolidates identical declarations. A previous static guard broke
		// multi-request scenarios: the second hook invocation had a fresh
		// $imports array but the static was still true → block-vars missing.
		$blockValueLines = [];
		foreach (self::registered() as $blockType => $blockConfigDir) {
			$blockValues   = self::loadValues($blockType);
			$blockDefaults = $blockValues['defaults'];
			$blockOverrides = $blockValues['overrides'];

			foreach ($blockDefaults as $groupKey => $group) {
				if (!is_array($group)) continue;

				// vars: flat single/multi-value variables (padding, radius, …)
				if (isset($group['vars'])) {
					foreach ($group['vars'] as $varName => $def) {
						$defaultVal = is_array($def) ? ($def['value'] ?? '') : $def;
						$override = $blockOverrides[$varName] ?? null;
						$prefix = '--' . $blockType . '-' . $varName;

						// Multi-value with suffixes (small/large, top-left/-right/…)
						if (is_array($defaultVal) && isset($def['suffixes'])) {
							$vals = is_array($override) ? $override : $defaultVal;
							foreach ($def['suffixes'] as $i => $suffix) {
								$blockValueLines[] = "\t" . $prefix . $suffix . ': ' . ($vals[$i] ?? '') . ';';
							}
							continue;
						}

						// Plain array (no suffixes) → join with spaces
						if (is_array($defaultVal)) {
							$vals = is_array($override) ? $override : $defaultVal;
							$blockValueLines[] = "\t" . $prefix . ': ' . implode(' ', $vals) . ';';
							continue;
						}

						// Scalar (single value or color)
						$val = $override ?? $defaultVal;
						$blockValueLines[] = "\t" . $prefix . ': ' . $val . ';';
					}
				}

				// colors: multi-theme colors ({ default, variant, variant2 })
				// Override format: nested by theme — { default: {…}, variant: {…}, variant2: {…} }
				if (isset($group['colors'])) {
					foreach ($group['colors'] as $varName => $themes) {
						if (!is_array($themes)) continue;
						foreach ($themes as $theme => $themeValue) {
							$override = $blockOverrides[$theme][$varName] ?? null;
							$suffix = $theme === 'default' ? '' : '-' . $theme;
							$blockValueLines[] = "\t--" . $blockType . '-' . $varName . $suffix . ': ' . ($override ?? $themeValue) . ';';
						}
					}
				}
			}
		}
		if (!empty($blockValueLines)) {
			$imports[] = ":root {\n" . implode("\n", $blockValueLines) . "\n}";
		}

		// Sprites stub
		$spritesDir     = kirby()->root('site') . '/patches/sprites';
		$spriteOverride = $spritesDir . '/symbols.txt';
		$spriteStub     = $spritesDir . '/_symbols.txt';
		$spriteDefault  = $pluginDir  . '/assets/sprites/symbols.txt';
		if (!is_dir($spritesDir)) mkdir($spritesDir, 0777, true);
		if (!file_exists($spriteOverride) && !file_exists($spriteStub) && file_exists($spriteDefault)) {
			file_put_contents($spriteStub, file_get_contents($spriteDefault));
		}
	}


	/**
	 * Generates public/assets/css/panel-colors.css from the plugin's colors.css.
	 * Called by projectbuilder-hook for the pagewizard/colors Panel API.
	 */
	public static function panelColorsSetup(string $pluginDir): void
	{
		if (self::$panelColorsGenerated) return;
		self::$panelColorsGenerated = true;

		// Read color values directly from JSON configs (always from pagewizard plugin)
		$elements = self::pluginConfig('elements');
		$global   = self::pluginConfig('global');

		// Merge with projectwizard overrides (only the ['global'] slice is relevant here)
		$elementsOverrides = self::projectOverride('elements')['global'] ?? [];
		$globalOverrides   = self::projectOverride('global')['global']   ?? [];

		// Collect all color definitions from JSON (elements + global)
		$allColors = [];
		foreach ([$elements, $global] as $source) {
			foreach ($source as $group) {
				if (!isset($group['colors'])) continue;
				foreach ($group['colors'] as $varName => $colorDef) {
					$allColors[$varName] = $colorDef;
				}
			}
		}

		// Map JSON variable names → panel color names
		$colorMap = [
			'block-background'                  => 'pw-color-block-background',
			'block-link'                        => 'pw-color-link',
			'element-heading-text'              => 'pw-color-heading',
			'element-heading-marked-text'       => 'pw-color-heading-marked-text',
			'element-heading-marked-background' => 'pw-color-heading-marked-background',
			'element-heading-flourish-color'    => 'pw-color-heading-flourish-color',
			'element-tagline-text'              => 'pw-color-tagline',
			'element-editor-text'               => 'pw-color-text',
			'element-button-text'               => 'pw-color-button-text',
			'element-button-background'         => 'pw-color-button-background',
			'element-button-icon'               => 'pw-color-button-icon',
			'element-icon-fill'                 => 'pw-color-icon',
			'element-caption-text'              => 'pw-color-caption',
			'element-quote-text'                => 'pw-color-quote',
			'element-cite-text'                 => 'pw-color-cite',
			'element-breadcrumb-text'           => 'pw-color-breadcrumb',
		];

		// Build theme palettes (default, variant, variant2, variant3)
		$themes = ['default', 'variant', 'variant2', 'variant3'];
		$palettes = [];
		foreach ($themes as $theme) {
			$palette = [];
			foreach ($colorMap as $jsonVar => $panelVar) {
				if (!isset($allColors[$jsonVar][$theme])) continue;
				// Override from projectwizard (stored under global.{theme}.{varName})
				$value = $elementsOverrides[$theme][$jsonVar]
					?? $globalOverrides[$theme][$jsonVar]
					?? $allColors[$jsonVar][$theme];
				$palette[$panelVar] = $value;
			}
			$palettes[$theme] = $palette;
		}

		// Generate panel-colors.css
		$varLines = function (array $colors): string {
			$lines = [];
			foreach ($colors as $key => $value) {
				$lines[] = "\t--" . $key . ': ' . $value . ';';
			}
			return implode("\n", $lines);
		};

		$css = "/* This file is auto-generated from JSON configs. Do not edit manually! */\n\n" .
			":root {\n" . $varLines($palettes['default']) . "\n}\n\n" .
			"[data-style=\"variant\"] {\n" . $varLines($palettes['variant']) . "\n}\n";
		if (!empty($palettes['variant2'])) {
			$css .= "\n[data-style=\"variant2\"] {\n" . $varLines($palettes['variant2']) . "\n}\n";
		}
		if (!empty($palettes['variant3'])) {
			$css .= "\n[data-style=\"variant3\"] {\n" . $varLines($palettes['variant3']) . "\n}\n";
		}

		// Plugin-specific item colors (from each registered block's values.items.colors)
		$pluginPalettes = ['default' => [], 'variant' => [], 'variant2' => [], 'variant3' => []];
		foreach (self::registered() as $blockType => $blockConfigDir) {
			$blockSettings = self::readJson($blockConfigDir . '/settings.json');
			$blockOverrides = self::projectOverride($blockType);
			foreach ($blockSettings['values'] ?? [] as $groupKey => $group) {
				if (empty($group['colors']) || !is_array($group['colors'])) continue;
				foreach ($group['colors'] as $colorKey => $colorDef) {
					foreach (['default', 'variant', 'variant2', 'variant3'] as $theme) {
						if (!isset($colorDef[$theme])) continue;
						$value = $blockOverrides[$theme][$colorKey] ?? $colorDef[$theme];
						$pluginPalettes[$theme][$blockType . '-' . $colorKey] = $value;
					}
				}
			}
		}
		if (!empty($pluginPalettes['default'])) {
			$css .= "\n:root {\n" . $varLines($pluginPalettes['default']) . "\n}\n";
			$css .= "\n[data-style=\"variant\"] {\n" . $varLines($pluginPalettes['variant']) . "\n}\n";
			if (!empty($pluginPalettes['variant2'])) {
				$css .= "\n[data-style=\"variant2\"] {\n" . $varLines($pluginPalettes['variant2']) . "\n}\n";
			}
			if (!empty($pluginPalettes['variant3'])) {
				$css .= "\n[data-style=\"variant3\"] {\n" . $varLines($pluginPalettes['variant3']) . "\n}\n";
			}
		}

		file_put_contents(kirby()->root('index') . '/assets/css/panel-colors.css', $css);
	}

	/**
	 * Build common tabs (grid, spacing, theme) and add them to $tabs.
	 */
	public static function buildTabs(string $blockType, array $defaults, array $tabSettings, array &$tabs): void
	{
		/* -------------- Grid Tab --------------*/
		$enabled = !empty($tabSettings['grid']) || !empty($tabSettings['tab-grid']);
		self::addTab($tabs, 'grid', $enabled, pwGrid::layout($blockType, $defaults));
	}

	/**
	 * The route:after hook body — invoked from every project's
	 * projectbuilder.php. Ensures required project directories exist,
	 * generates stub files for CSS/JS/snippets/templates, and rebuilds
	 * storage/temp/{tailwind,vars}.css from plugin sources + overrides.
	 *
	 * Kept as a single static entry point so projectbuilder.php in each
	 * project stays a minimal wrapper — no logic to maintain per project.
	 */
	public static function runProjectBuilder(): void
	{
		// Ensure required output/patches directories exist.
		// npm run ... writes final css/js into /public/assets/.
		$dirs = [
			kirby()->root('index') . '/assets/js',
			kirby()->root('index') . '/assets/css',
			kirby()->root('site')  . '/patches/css',
			kirby()->root('site')  . '/patches/js',
			kirby()->root('site')  . '/blueprints/blocks',
			kirby()->root('site')  . '/blueprints/pages',
			kirby()->root('site')  . '/snippets',
			kirby()->root('site')  . '/templates',
		];
		foreach ($dirs as $dir) {
			if (!is_dir($dir)) mkdir($dir, 0777, true);
		}

		// Temp directory for temporary css file.
		// Fallback for first-run setup when the current Kirby bootstrap
		// has no 'temp' root defined yet (new public/index.php not loaded).
		$tempDir = kirby()->root('temp') ?? kirby()->root('site') . '/../storage/temp';
		if (!is_dir($tempDir)) mkdir($tempDir, 0777, true);

		$patchesJsDir = kirby()->root('site') . '/patches/js';
		$outputFile   = $tempDir . '/tailwind.css';
		$imports      = [];

		// Iterate every plugin that has a src/css/.stub marker.
		foreach (kirby()->plugins() as $plugin) {
			$marker = $plugin->root() . '/src/css/.stub';
			if (!file_exists($marker)) continue;

			$pluginDir    = $plugin->root();
			$dirName      = basename($pluginDir);
			$pluginName   = $plugin->name();
			$packageName  = substr(strrchr($pluginName, '/'), 1);

			$imports[] = "\n/* Plugin: " . $packageName . " */";

			// Plugin-specific tailwind setup (CSS vars, stubs).
			self::tailwindSetup($pluginDir, $imports);

			$patchDir      = kirby()->root('site') . '/patches/css/' . $packageName;
			$pluginCssDir  = $plugin->root() . '/src/css';

			// Import active CSS patches or plugin defaults, sorted by name.
			if (is_dir($patchDir)) {
				$cssFiles = glob($pluginCssDir . '/*.css') ?: [];
				sort($cssFiles);
				foreach ($cssFiles as $cssFile) {
					$moduleName    = basename($cssFile);
					$modulePatch   = $patchDir . '/' . $moduleName;
					$moduleDefault = $cssFile;
					if (file_exists($modulePatch)) {
						$imports[] = "@import '../../site/patches/css/" . $packageName . "/" . $moduleName . "';";
					} elseif (file_exists($moduleDefault)) {
						$imports[] = "@import '../../site/plugins/" . $dirName . "/src/css/" . $moduleName . "';";
					}
				}
			} else {
				$cssFiles = glob($pluginCssDir . '/*.css') ?: [];
				sort($cssFiles);
				foreach ($cssFiles as $cssFile) {
					$moduleName = basename($cssFile);
					$imports[] = "@import '../../site/plugins/" . $dirName . "/src/css/" . $moduleName . "';";
				}
			}

			// Tailwind watcher entries for the plugin's snippets and templates.
			$imports[] = "@source '../../site/plugins/" . $dirName . "/snippets';";
			$imports[] = "@source '../../site/plugins/" . $dirName . "/templates';";

			// Generate CSS stubs for each plugin CSS module.
			if (is_dir($pluginCssDir)) {
				$cssFiles = glob($pluginCssDir . '/*.css') ?: [];
				if (!empty($cssFiles)) {
					if (!is_dir($patchDir)) mkdir($patchDir, 0777, true);
					foreach ($cssFiles as $cssFile) {
						$fileName   = basename($cssFile);
						$activeFile = $patchDir . '/' . $fileName;
						$stubFile   = $patchDir . '/_' . $fileName;
						if (!file_exists($activeFile) && !file_exists($stubFile)) {
							$comment    = "/* Remove the leading underscore from filename and start editing */\n\n";
							$cssContent = preg_replace('/^\/\* DO NOT MODIFY THIS FILE[^\*]*\*\/\n?/m', '', file_get_contents($cssFile));
							file_put_contents($stubFile, $comment . ltrim($cssContent));
						}
					}
				}
			}

			// Generate JS stubs (src/js/*.js).
			$pluginJsDir = $plugin->root() . '/src/js';
			if (is_dir($pluginJsDir)) {
				$jsFiles = glob($pluginJsDir . '/*.js') ?: [];
				foreach ($jsFiles as $jsFile) {
					$fileName   = basename($jsFile);
					$activeFile = $patchesJsDir . '/' . $fileName;
					$stubFile   = $patchesJsDir . '/_' . $fileName;
					if (!file_exists($activeFile) && !file_exists($stubFile)) {
						$comment = "/* Remove the leading underscore from filename and start editing */\n\n";
						file_put_contents($stubFile, $comment . file_get_contents($jsFile));
					}
				}
			}

			// Generate snippet stubs (only if snippets/.stub marker exists).
			$snippetMarker     = $plugin->root() . '/snippets/.stub';
			$pluginSnippetsDir = $plugin->root() . '/snippets';
			if (file_exists($snippetMarker) && is_dir($pluginSnippetsDir)) {
				if (strpos($packageName, 'kirbyblock-') === 0) {
					// kirbyblock-* → site/snippets/blocks/_pw<name>.php
					$snippetBlocksDir = kirby()->root('site') . '/snippets/blocks';
					if (!is_dir($snippetBlocksDir)) mkdir($snippetBlocksDir, 0777, true);
					$blockName   = str_replace('kirbyblock-', '', $packageName);
					$snippetName = 'pw' . strtolower($blockName);
					$snippetFile = $pluginSnippetsDir . '/index.php';
					if (file_exists($snippetFile)) {
						$stubSnippet   = $snippetBlocksDir . '/_' . $snippetName . '.php';
						$activeSnippet = $snippetBlocksDir . '/' . $snippetName . '.php';
						if (!file_exists($activeSnippet) && !file_exists($stubSnippet)) {
							$originalContent = file_get_contents($snippetFile);
							$originalContent = preg_replace('/^<\?php\s*\n?/', '', $originalContent, 1);
							$comment         = "<?php\n/* Remove the leading underscore from filename and start editing */\n\n";
							file_put_contents($stubSnippet, $comment . $originalContent);
						}
					}
				} elseif ($packageName === 'kirby-pagewizard') {
					// kirby-pagewizard → site/snippets/_*.php (flat)
					$projectSnippetsDir = kirby()->root('site') . '/snippets';
					if (!is_dir($projectSnippetsDir)) mkdir($projectSnippetsDir, 0777, true);
					$snippetFiles = glob($pluginSnippetsDir . '/*.php') ?: [];
					foreach ($snippetFiles as $snippetFile) {
						$snippetName   = basename($snippetFile);
						$stubSnippet   = $projectSnippetsDir . '/_' . $snippetName;
						$activeSnippet = $projectSnippetsDir . '/' . $snippetName;
						if (!file_exists($activeSnippet) && !file_exists($stubSnippet)) {
							$originalContent = file_get_contents($snippetFile);
							if (preg_match('/^<\?php/', $originalContent)) {
								$originalContent = preg_replace('/^<\?php\s*\n?/', '', $originalContent, 1);
								$comment         = "<?php\n/* Remove the leading underscore from filename and start editing */\n\n";
								file_put_contents($stubSnippet, $comment . $originalContent);
							} else {
								$comment = "<?php /* Remove the leading underscore from filename and start editing */ ?>\n";
								file_put_contents($stubSnippet, $comment . $originalContent);
							}
						}
					}
				}
			}

			// Generate template stubs (only if templates/.stub marker exists).
			$templateMarker     = $plugin->root() . '/templates/.stub';
			$pluginTemplatesDir = $plugin->root() . '/templates';
			if (file_exists($templateMarker) && is_dir($pluginTemplatesDir)) {
				$projectTemplatesDir = kirby()->root('site') . '/templates';
				if (!is_dir($projectTemplatesDir)) mkdir($projectTemplatesDir, 0777, true);
				$templateFiles = glob($pluginTemplatesDir . '/*.php') ?: [];
				foreach ($templateFiles as $templateFile) {
					$templateName   = basename($templateFile);
					$stubTemplate   = $projectTemplatesDir . '/_' . $templateName;
					$activeTemplate = $projectTemplatesDir . '/' . $templateName;
					if (!file_exists($activeTemplate) && !file_exists($stubTemplate)) {
						$originalContent = file_get_contents($templateFile);
						$originalContent = preg_replace('/^<\?php\s*\n?/', '', $originalContent, 1);
						$comment         = "<?php\n/* Remove the leading underscore from filename and start editing */\n\n";
						file_put_contents($stubTemplate, $comment . $originalContent);
					}
				}
			}

			// panel-colors.css for the pagewizard/colors API.
			self::panelColorsSetup($pluginDir);
		}

		// Tailwind watcher — project-level snippets and templates.
		$watchers = [
			"@source '../../site/snippets';",
			"@source '../../site/templates';",
		];

		// Split imports: @font-face + :root vars → vars.css, everything else → tailwind.css.
		$varsContent = [];
		$cssImports  = [];
		foreach ($imports as $entry) {
			$trimmed = trim($entry);
			if (str_starts_with($trimmed, '@import') || str_starts_with($trimmed, '@source') || str_starts_with($trimmed, "\n/*")) {
				$cssImports[] = $entry;
			} else {
				$varsContent[] = $entry;
			}
		}

		// vars.css — @font-face + :root blocks (watched by Tailwind via @import).
		// Only write when content changed to avoid triggering unnecessary Tailwind rebuilds.
		$varsPath = $tempDir . '/vars.css';
		$varsNew  = "/* Auto-generated — do not edit */\n\n" . implode("\n", $varsContent);
		// Convert 8-digit hex (#rrggbbaa) to rgba() — Tailwind's CSS minifier
		// strips the alpha channel when it collapses e.g. #ff0000 to `red`,
		// dropping the trailing #38 (alpha). rgba() is safe from that.
		$varsNew = preg_replace_callback(
			'/#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})\b/i',
			function ($m) {
				return sprintf(
					'rgba(%d, %d, %d, %s)',
					hexdec($m[1]),
					hexdec($m[2]),
					hexdec($m[3]),
					rtrim(rtrim(number_format(hexdec($m[4]) / 255, 3), '0'), '.')
				);
			},
			$varsNew
		);
		if (!file_exists($varsPath) || file_get_contents($varsPath) !== $varsNew) {
			file_put_contents($varsPath, $varsNew);
		}

		// tailwind.css — static shell with @import to vars.css.
		$tailwindNew =
			"/* This file is automatically generated by a hook, when \n" .
			"Kirby is in debug mode. Do not edit this file manually! */\n\n" .
			"@import './vars.css';\n\n" .
			"/* TailwindCSS */\n@import 'tailwindcss';\n\n" .
			"@plugin 'tailwindcss-debug-screens' {\n\tclassName: \"debug-screens\";\n\tposition: \"bottom, left\";\n\tprefix: \"\";\n}\n\n" .
			"/* Tailwind Watcher */\n" . implode("\n", $watchers) . "\n" .
			implode("\n", $cssImports);
		if (!file_exists($outputFile) || file_get_contents($outputFile) !== $tailwindNew) {
			file_put_contents($outputFile, $tailwindNew);
		}
	}
}
