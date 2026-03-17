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
	 * Load settings and defaults from JSON files, merged with config.php overrides.
	 */
	public static function load(string $blockType): array
	{
		$configDir = self::$configPaths[$blockType] ?? null;

		if ($configDir === null) {
			return ['content' => [], 'tabs' => [], 'defaults' => [], 'fields' => [], 'editor' => [], 'layout' => [], 'style' => [], 'effects' => [], 'settings' => [], 'field-options' => []];
		}

		/* -------------- Block Settings (feature toggles) --------------*/
		$settingsFile = $configDir . '/settings.json';
		$settingsRaw = file_exists($settingsFile)
			? json_decode(file_get_contents($settingsFile), true)
			: [];

		$tabSettings = $settingsRaw['tabs'] ?? [];

		// fields: nested { content: {}, layout: {}, style: {}, settings: {} } or flat (legacy)
		$fieldsRaw   = $settingsRaw['fields'] ?? [];
		$isNested    = isset($fieldsRaw['content']) || isset($fieldsRaw['layout']) || isset($fieldsRaw['style']) || isset($fieldsRaw['settings']) || isset($fieldsRaw['effects']);
		$rawContent  = $isNested ? ($fieldsRaw['content']  ?? []) : $fieldsRaw;
		$layoutVis   = $isNested ? ($fieldsRaw['layout']   ?? []) : [];
		$styleVis    = $isNested ? ($fieldsRaw['style']    ?? []) : [];
		$effectsVis  = $isNested ? ($fieldsRaw['effects']  ?? []) : [];
		$settingsVis = $isNested ? ($fieldsRaw['settings'] ?? []) : [];

		[$settings, $fieldOptions] = self::parseContentSettings($rawContent);

		/* -------------- Block Defaults (field values) --------------*/
		$defaultsFile = $configDir . '/defaults.json';
		$defaultsRaw = file_exists($defaultsFile)
			? json_decode(file_get_contents($defaultsFile), true)
			: [];

		$fields = self::flattenContentDefaults($defaultsRaw['content'] ?? []);
		if (isset($defaultsRaw['block'])) {
			$defaults = $defaultsRaw['block'];
		} else {
			$defaults = array_merge(
				$defaultsRaw['layout']   ?? [],
				$defaultsRaw['style']    ?? [],
				$defaultsRaw['grid']     ?? [],
				$defaultsRaw['settings'] ?? [],
				$defaultsRaw['effects']  ?? []
			);
		}

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
			}
			if (!empty($cfgVis['fields']['layout']))   $layoutVis   = array_merge($layoutVis,   $cfgVis['fields']['layout']);
			if (!empty($cfgVis['fields']['style']))    $styleVis    = array_merge($styleVis,    $cfgVis['fields']['style']);
			if (!empty($cfgVis['fields']['effects']))  $effectsVis  = array_merge($effectsVis,  $cfgVis['fields']['effects']);
			if (!empty($cfgVis['fields']['settings'])) $settingsVis = array_merge($settingsVis, $cfgVis['fields']['settings']);
		}
		// defaults: nested { layout: {}, style: {}, grid: {}, settings: {}, effects: {} } or flat
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
	 * Flatten nested defaults.json content into a flat key map.
	 * New format: { "heading": {"align":"left","size":"2xl"} } → { "align-heading":"left", "size-heading":"2xl" }
	 * Old format: { "align-heading": "left" } → passed through unchanged.
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
	 * Parse settings.json fields.content into $settings (backward-compat) and $fieldOptions (new).
	 * New format: { "heading": {"align":[...],"sizes":[...]} } → settings['heading']=true, fieldOptions['heading']={...}
	 * Old format: { "heading": true, "editor": ["writer"] } → passed through, editor gets fieldOptions['editor']['mode']
	 */
	private static function parseContentSettings(array $raw): array
	{
		$settings     = [];
		$fieldOptions = [];
		foreach ($raw as $fieldKey => $fieldValue) {
			if (is_array($fieldValue) && !array_is_list($fieldValue)) {
				// New nested format (associative array)
				$settings[$fieldKey]     = isset($fieldValue['mode']) ? $fieldValue['mode'] : true;
				$fieldOptions[$fieldKey] = $fieldValue;
			} else {
				// Old format: bool, or indexed array (legacy editor modes)
				$settings[$fieldKey] = $fieldValue;
				if (is_array($fieldValue)) {
					$fieldOptions[$fieldKey] = ['mode' => $fieldValue];
				}
			}
		}
		return [$settings, $fieldOptions];
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
	 * Reads navigation.json + navigation-colors.json, merges with project overrides,
	 * appends :root { --nav-* } to $imports, and creates config/sprites stubs.
	 */
	public static function tailwindSetup(string $pluginDir, array &$imports): void
	{
		$patchConfigDir = kirby()->root('site') . '/patches/config';
		if (!is_dir($patchConfigDir)) mkdir($patchConfigDir, 0777, true);

		$jsonSets = [
			['file' => 'navigation.json',        'prefix' => '--nav-'],
			['file' => 'navigation-colors.json', 'prefix' => '--nav-'],
		];

		$rootLines = [];
		foreach ($jsonSets as $set) {
			$defaultFile  = $pluginDir . '/config/' . $set['file'];
			$overrideFile = $patchConfigDir . '/' . $set['file'];
			$stubFile     = $patchConfigDir . '/_' . $set['file'];

			$defaults = file_exists($defaultFile)  ? (json_decode(file_get_contents($defaultFile),  true) ?? []) : [];
			$override = file_exists($overrideFile) ? (json_decode(file_get_contents($overrideFile), true) ?? []) : [];
			$merged   = array_merge($defaults, $override);

			if (!file_exists($overrideFile) && !file_exists($stubFile) && file_exists($defaultFile)) {
				file_put_contents($stubFile, file_get_contents($defaultFile));
			}

			foreach ($merged as $key => $value) {
				if (!is_string($value) || $value === '') continue;
				$rootLines[] = "\t" . $set['prefix'] . $key . ': ' . $value . ';';
			}
		}

		if (!empty($rootLines)) {
			$imports[] = ":root {\n" . implode("\n", $rootLines) . "\n}";
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
