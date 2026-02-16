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
			return ['settings' => [], 'defaults' => []];
		}

		/* -------------- Block Settings (feature toggles) --------------*/
		$settingsFile = $configDir . '/settings.json';
		$settings = file_exists($settingsFile)
			? json_decode(file_get_contents($settingsFile), true)
			: [];

		/* -------------- Block Defaults (field values) --------------*/
		$defaultsFile = $configDir . '/defaults.json';
		$defaults = file_exists($defaultsFile)
			? json_decode(file_get_contents($defaultsFile), true)
			: [];

		/* -------------- Config overrides from config.php --------------*/
		$raw = option("kirbydesk.pagewizard.kirbyblocks.{$blockType}", []);
		$cfg = is_array($raw) ? $raw : [];
		if (!empty($cfg['settings']) && is_array($cfg['settings'])) {
			$settings = array_merge($settings, $cfg['settings']);
		}
		if (!empty($cfg['defaults']) && is_array($cfg['defaults'])) {
			$defaults = array_merge($defaults, $cfg['defaults']);
		}

		return [
			'settings' => $settings,
			'defaults' => $defaults,
		];
	}

	/**
	 * Get settings for a block type.
	 */
	public static function settings(string $blockType): array
	{
		return self::load($blockType)['settings'];
	}

	/**
	 * Build common tabs (grid, spacing, theme) and add them to $tabs.
	 */
	public static function buildTabs(string $blockType, array $defaults, array $settings, array &$tabs): void
	{
		/* -------------- Spacing Tab --------------*/
		$spacingDefaults = [
			'marginTop'    => $defaults['margin-top'],
			'marginBottom' => $defaults['margin-bottom'],
			'paddingTop'   => $defaults['padding-top'],
			'paddingBottom'=> $defaults['padding-bottom'],
		];
		if (!empty($settings['tab-spacing'])) {
			$tabs['spacing'] = pwSpacing::options($blockType, $spacingDefaults);
		} else {
			foreach ($spacingDefaults as $key => $value) {
				$tabs['content']['fields'][$key] = ['type' => 'hidden', 'default' => $value];
			}
		}

		/* -------------- Grid Tab --------------*/
		$gridDefaults = [
			'gridSizeSm'   => $defaults['grid-size-sm'],
			'gridOffsetSm' => $defaults['grid-offset-sm'],
			'gridSizeMd'   => $defaults['grid-size-md'],
			'gridOffsetMd' => $defaults['grid-offset-md'],
			'gridSizeLg'   => $defaults['grid-size-lg'],
			'gridOffsetLg' => $defaults['grid-offset-lg'],
			'gridSizeXl'   => $defaults['grid-size-xl'],
			'gridOffsetXl' => $defaults['grid-offset-xl'],
		];
		if (!empty($settings['tab-grid'])) {
			$tabs['grid'] = pwGrid::layout($blockType, $gridDefaults);
		} else {
			foreach ($gridDefaults as $key => $value) {
				$tabs['content']['fields'][$key] = ['type' => 'hidden', 'default' => $value];
			}
		}

		/* -------------- Theme Tab --------------*/
		$themeDefaults = [
			'style'          => $defaults['style'],
			'backgroundsize' => $defaults['background-size'],
			'buttons'        => $settings['buttons'] ?? false,
		];
		if (!empty($settings['tab-theme'])) {
			$tabs['theme'] = pwTheme::options($blockType, $themeDefaults);
		} else {
			foreach (['style', 'backgroundsize'] as $key) {
				$tabs['content']['fields'][$key] = ['type' => 'hidden', 'default' => $themeDefaults[$key]];
			}
		}
	}
}
