<?php

class pwConfig
{
	private static array $configPaths = [];

	/**
	 * Register a block type's config directory (call from plugin index.php).
	 */
	public static function register(string $blockType, string $configDir): void
	{
		self::$configPaths[$blockType] = $configDir;
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
		$settingsFile = $configDir . '/settings.json';
		$settingsRaw = file_exists($settingsFile)
			? json_decode(file_get_contents($settingsFile), true)
			: [];

		$tabSettings = $settingsRaw['tabs'] ?? [];

		$fieldsRaw   = $settingsRaw['fields'] ?? [];
		$rawContent  = $fieldsRaw['content']  ?? [];
		$layoutVis   = $fieldsRaw['layout']   ?? [];
		$styleVis    = $fieldsRaw['style']    ?? [];
		$effectsVis  = $fieldsRaw['effects']  ?? [];
		$settingsVis = $fieldsRaw['settings'] ?? [];

		[$settings, $fieldOptions] = self::parseContentSettings($rawContent);
		$fields = self::extractContentDefaults($rawContent);

		$defaults = array_merge(
			self::extractCategoryDefaults($layoutVis),
			self::extractCategoryDefaults($styleVis),
			self::extractCategoryDefaults($fieldsRaw['grid'] ?? []),
			self::extractCategoryDefaults($settingsVis),
			self::extractCategoryDefaults($effectsVis)
		);

		/* -------------- Editor config --------------*/
		$editorFile = $configDir . '/editor.json';
		$editor = file_exists($editorFile)
			? json_decode(file_get_contents($editorFile), true)
			: [];

		/* -------------- Config overrides from config.php --------------*/
		$raw = option("kirbydesk.pagewizard.kirbyblocks.{$blockType}", []);
		$cfg = is_array($raw) ? $raw : [];

		// Support both flat format ($cfg['tabs']) and wrapped format ($cfg['settings']['tabs'])
		$cfgVis = (!empty($cfg['settings']) && is_array($cfg['settings'])) ? $cfg['settings'] : $cfg;

		// tabs
		if (!empty($cfgVis['tabs']) && is_array($cfgVis['tabs'])) {
			$tabSettings = array_merge($tabSettings, $cfgVis['tabs']);
		}
		// fields: nested { content: {}, layout: {}, style: {}, settings: {} }
		if (!empty($cfgVis['fields']) && is_array($cfgVis['fields'])) {
			if (!empty($cfgVis['fields']['content'])) {
				[$cfgSettings, $cfgFieldOptions] = self::parseContentSettings($cfgVis['fields']['content']);
				$settings     = array_merge($settings,     $cfgSettings);
				$fieldOptions = array_merge($fieldOptions, $cfgFieldOptions);
				$fields       = array_merge($fields, self::extractContentDefaults($cfgVis['fields']['content']));
			}
			if (!empty($cfgVis['fields']['layout']))   $layoutVis   = array_merge($layoutVis,   $cfgVis['fields']['layout']);
			if (!empty($cfgVis['fields']['style']))    $styleVis    = array_merge($styleVis,    $cfgVis['fields']['style']);
			if (!empty($cfgVis['fields']['effects']))  $effectsVis  = array_merge($effectsVis,  $cfgVis['fields']['effects']);
			if (!empty($cfgVis['fields']['settings'])) $settingsVis = array_merge($settingsVis, $cfgVis['fields']['settings']);
		}
		// defaults overrides (legacy format from existing stored overrides)
		if (!empty($cfg['defaults']) && is_array($cfg['defaults'])) {
			$isNested = isset($cfg['defaults']['layout']) || isset($cfg['defaults']['style'])
				|| isset($cfg['defaults']['grid']) || isset($cfg['defaults']['settings'])
				|| isset($cfg['defaults']['effects']);
			if ($isNested) {
				$flatOverrides = array_merge(
					$cfg['defaults']['layout']   ?? [],
					$cfg['defaults']['style']    ?? [],
					$cfg['defaults']['grid']     ?? [],
					$cfg['defaults']['settings'] ?? [],
					$cfg['defaults']['effects']  ?? []
				);
				$defaults = array_merge($defaults, $flatOverrides);
				if (!empty($cfg['defaults']['content'])) {
					$fields = array_merge($fields, self::flattenContentDefaults($cfg['defaults']['content']));
				}
			} else {
				$defaults = array_merge($defaults, $cfg['defaults']);
			}
		}
		if (!empty($cfg['editor']) && is_array($cfg['editor'])) {
			foreach ($cfg['editor'] as $key => $value) {
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

		// Fonts: load early so all sections can reference them for font-family lookups
		$fontsDefault = $pluginDir . '/config/fonts.json';
		$fontsProjectFile = kirby()->root('site') . '/config/projectwizard/fonts.json';
		$builtinFonts = file_exists($fontsDefault) ? (json_decode(file_get_contents($fontsDefault), true) ?? []) : [];
		$projectFonts = file_exists($fontsProjectFile) ? (json_decode(file_get_contents($fontsProjectFile), true) ?? []) : [];
		unset($projectFonts['_default']);
		$allFonts = array_merge($builtinFonts, $projectFonts);

		// Navigation: read config/navigation.json (nested format), merge with projectwizard overrides
		$navDefault = $pluginDir . '/config/navigation.json';
		$navOverride = kirby()->root('site') . '/config/projectwizard/navigation.json';
		$nav = file_exists($navDefault) ? (json_decode(file_get_contents($navDefault), true) ?? []) : [];
		$navOverrides = [];
		if (file_exists($navOverride)) {
			$navOverrides = json_decode(file_get_contents($navOverride), true) ?? [];
		}

		$rootLines = [];
		$navLinesLg = [];
		$navLinesXl = [];
		foreach ($nav as $groupKey => $group) {
			if (!is_array($group) || !isset($group['vars'])) continue;
			foreach ($group['vars'] as $varName => $def) {
				// Responsive font-size (default/lg/xl)
				if (is_array($def) && isset($def['default']) && isset($def['lg']) && !isset($def['variant'])) {
					foreach (['default' => &$rootLines, 'lg' => &$navLinesLg, 'xl' => &$navLinesXl] as $bp => &$lines) {
						$override = ($navOverrides['global'][$bp][$varName] ?? null);
						$lines[] = "\t--nav-" . $varName . ': ' . ($override ?? $def[$bp]) . ';';
					}
					unset($lines);
					continue;
				}
				$defaultVal = is_array($def) ? ($def['value'] ?? '') : $def;
				$override = ($navOverrides['global'][$varName] ?? null);
				if (($def['type'] ?? null) === 'font-family') {
					$fontVal = $override ?? $defaultVal;
					$fontCategory = 'sans-serif';
					foreach ($allFonts as $f) {
						if ($f['family'] === $fontVal) {
							$fontCategory = $f['category'] ?? 'sans-serif';
							break;
						}
					}
					$rootLines[] = "\t--nav-" . $varName . ": '" . $fontVal . "', " . $fontCategory . ';';
				} elseif (($def['type'] ?? null) === 'color-pair' && isset($def['fields'])) {
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

		// Global: read config/global.json (layout + background colors), merge with projectwizard overrides
		$globalDefault = $pluginDir . '/config/global.json';
		$globalOverride = kirby()->root('site') . '/config/projectwizard/global.json';
		$global = file_exists($globalDefault) ? (json_decode(file_get_contents($globalDefault), true) ?? []) : [];
		$globalOverrides = [];
		if (file_exists($globalOverride)) {
			$globalOverrides = json_decode(file_get_contents($globalOverride), true) ?? [];
		}

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

		// Font sizes: read config/fontsizes.json, merge with projectwizard overrides
		$fontsDefault = $pluginDir . '/config/fontsizes.json';
		$fontsOverride = kirby()->root('site') . '/config/projectwizard/fontsizes.json';
		$fonts = file_exists($fontsDefault) ? (json_decode(file_get_contents($fontsDefault), true) ?? []) : [];
		$fontOverrides = [];
		if (file_exists($fontsOverride)) {
			$fontOverrides = json_decode(file_get_contents($fontsOverride), true) ?? [];
		}

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

		// Elements: read config/elements.json, merge with projectwizard overrides
		$elementsDefault = $pluginDir . '/config/elements.json';
		$elementsOverride = kirby()->root('site') . '/config/projectwizard/elements.json';
		$elements = file_exists($elementsDefault) ? (json_decode(file_get_contents($elementsDefault), true) ?? []) : [];
		$elementOverrides = [];
		if (file_exists($elementsOverride)) {
			$elementOverrides = json_decode(file_get_contents($elementsOverride), true) ?? [];
		}

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

		// Footer: read config/footer.json, merge with projectwizard overrides
		$footerDefault = $pluginDir . '/config/footer.json';
		$footerOverride = kirby()->root('site') . '/config/projectwizard/footer.json';
		$footer = file_exists($footerDefault) ? (json_decode(file_get_contents($footerDefault), true) ?? []) : [];
		$footerOverrides = [];
		if (file_exists($footerOverride)) {
			$footerOverrides = json_decode(file_get_contents($footerOverride), true) ?? [];
		}

		$footerLines = [];
		foreach ($footer as $groupKey => $group) {
			if (!is_array($group) || !isset($group['vars'])) continue;
			foreach ($group['vars'] as $varName => $def) {
				$defaultVal = is_array($def) ? ($def['value'] ?? '') : $def;
				$override = ($footerOverrides['global'][$varName] ?? null);
				if (($def['type'] ?? null) === 'font-family') {
					$fontVal = $override ?? $defaultVal;
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

		// Generate @font-face rules
		foreach ($allFonts as $font) {
			$autoItalic = !empty($font['italic']);
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
		$pluginCssDir = $pluginDir . '/src/css';
		$patchColorFile  = kirby()->root('site') . '/patches/css/kirby-pagewizard/colors.css';
		$srcColorFile    = $pluginCssDir . '/colors.css';
		$sourceColorFile = file_exists($patchColorFile) ? $patchColorFile : (file_exists($srcColorFile) ? $srcColorFile : null);

		if ($sourceColorFile) {
				$colorsCss = file_get_contents($sourceColorFile);

				// Extract all :root CSS variable definitions → used to resolve var() references
				$rootVars = [];
				preg_match_all('/:root\s*\{([^}]*)\}/s', $colorsCss, $rootMatches);
				foreach ($rootMatches[1] as $rootBlock) {
						preg_match_all('/--([a-zA-Z0-9_-]+)\s*:\s*([^;]+);/', $rootBlock, $varMatches, PREG_SET_ORDER);
						foreach ($varMatches as $vm) {
								$rootVars['--' . trim($vm[1])] = trim($vm[2]);
						}
				}

				// Resolve var(--something) to actual value (one level deep)
				$resolveVars = function (array $colors) use ($rootVars): array {
						foreach ($colors as $key => $value) {
								if (preg_match('/^var\((--[a-zA-Z0-9_-]+)\)$/', $value, $m)) {
										$colors[$key] = $rootVars[$m[1]] ?? $value;
								}
						}
						return $colors;
				};

				$exBlock = function (string $pattern) use ($colorsCss): ?string {
						if (!preg_match($pattern, $colorsCss, $m, PREG_OFFSET_CAPTURE)) return null;
						$p = $m[0][1] + strlen($m[0][0]) - 1;
						$d = 0; $i = $p; $l = strlen($colorsCss);
						while ($i < $l) {
								if ($colorsCss[$i] === '{') $d++;
								elseif ($colorsCss[$i] === '}') { $d--; if ($d === 0) break; }
								$i++;
						}
						return substr($colorsCss, $p + 1, $i - $p - 1);
				};

				$exValue = function (string $block, string $sel, string $prop): ?string {
						if ($sel === 'a') {
								if (!preg_match('/(?:^|[\n\r])\s*a\s*\{/', $block, $m, PREG_OFFSET_CAPTURE)) return null;
								$p = $m[0][1] + strlen($m[0][0]) - 1;
						} else {
								$pos = strpos($block, $sel);
								if ($pos === false) return null;
								$p = strpos($block, '{', $pos);
								if ($p === false) return null;
						}
						$d = 0; $i = $p; $l = strlen($block);
						while ($i < $l) {
								if ($block[$i] === '{') $d++;
								elseif ($block[$i] === '}') { $d--; if ($d === 0) break; }
								$i++;
						}
						$inner = substr($block, $p + 1, $i - $p - 1);
						$d = 0; $top = '';
						for ($j = 0; $j < strlen($inner); $j++) {
								if ($inner[$j] === '{') $d++;
								elseif ($inner[$j] === '}') $d--;
								elseif ($d === 0) $top .= $inner[$j];
						}
						return preg_match('/' . preg_quote($prop, '/') . '\s*:\s*([^;]+);/', $top, $pm) ? trim($pm[1]) : null;
				};

				$parseColorBlock = function (string $blockPattern) use ($exBlock, $exValue): array {
						$block = $exBlock($blockPattern);
						if (!$block) return [];
						$colors = [];
						$d = 0; $top = '';
						for ($i = 0; $i < strlen($block); $i++) {
								if ($block[$i] === '{') $d++;
								elseif ($block[$i] === '}') $d--;
								elseif ($d === 0) $top .= $block[$i];
						}
						if (preg_match('/background-color\s*:\s*([^;]+);/', $top, $m)) {
								$colors['pw-color-block-background'] = trim($m[1]);
						}
						$map = [
								'a'                                              => ['color'            => 'pw-color-link'],
								'[data-field="heading"]'                         => ['color'            => 'pw-color-heading'],
								'[data-field="tagline"]'                         => ['color'            => 'pw-color-tagline'],
								'[data-field="textarea"]'                        => ['color'            => 'pw-color-text'],
								'[data-field="button"] a'                        => [
										'color'            => 'pw-color-button-text',
										'background-color' => 'pw-color-button-background',
								],
								'[data-field="icon"] svg'                        => ['fill'             => 'pw-color-icon'],
								'[data-field="caption"]'                         => ['color'            => 'pw-color-caption'],
								'[data-field="quote"]'                           => ['color'            => 'pw-color-quote'],
								'[data-field="cite"]'                            => ['color'            => 'pw-color-cite'],
								'[data-field="breadcrumb"]'                      => ['color'            => 'pw-color-breadcrumb'],
						];
						foreach ($map as $sel => $props) {
								foreach ($props as $prop => $key) {
										$val = $exValue($block, $sel, $prop);
										if ($val !== null) $colors[$key] = $val;
								}
						}
						return $colors;
				};

				$defaultColors  = $resolveVars($parseColorBlock('/section\[data-block\]\s*\{/'));
				$variantColors  = $resolveVars($parseColorBlock('/section\[data-block\]\[data-style="variant"\]\s*\{/'));
				$variant2Colors = $resolveVars($parseColorBlock('/section\[data-block\]\[data-style="variant2"\]\s*\{/'));

				// Button colors come from separate combined selectors — read directly from :root variables
				$buttonMap = [
					'default'  => ['text' => '--element-button-text',          'bg' => '--element-button-background'],
					'variant'  => ['text' => '--element-button-text-variant',  'bg' => '--element-button-background-variant'],
					'variant2' => ['text' => '--element-button-text-variant2', 'bg' => '--element-button-background-variant2'],
				];
				foreach ($buttonMap as $theme => $keys) {
					$colors = &${$theme . 'Colors'};
					if (!isset($colors['pw-color-button-text']) && isset($rootVars[$keys['text']])) {
						$colors['pw-color-button-text']       = $rootVars[$keys['text']];
						$colors['pw-color-button-background'] = $rootVars[$keys['bg']] ?? '';
					}
				}

				$varLines = function (array $colors): string {
						$lines = [];
						foreach ($colors as $key => $value) {
								$lines[] = "\t--" . $key . ': ' . $value . ';';
						}
						return implode("\n", $lines);
				};

				$css = "/* This file is auto-generated by tailwind-hook from colors.css. Do not edit manually! */\n\n" .
					":root {\n" . $varLines($defaultColors) . "\n}\n\n" .
					"[data-style=\"variant\"] {\n" . $varLines($variantColors) . "\n}\n";
				if (!empty($variant2Colors)) {
					$css .= "\n[data-style=\"variant2\"] {\n" . $varLines($variant2Colors) . "\n}\n";
				}
				file_put_contents(kirby()->root('index') . '/assets/css/panel-colors.css', $css);
		}
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
}
