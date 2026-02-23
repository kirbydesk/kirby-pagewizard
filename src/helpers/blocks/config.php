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
			return ['settings' => [], 'tabs' => [], 'defaults' => [], 'fields' => [], 'editor' => []];
		}

		/* -------------- Block Settings (feature toggles) --------------*/
		$settingsFile = $configDir . '/settings.json';
		$settingsRaw = file_exists($settingsFile)
			? json_decode(file_get_contents($settingsFile), true)
			: [];

		$settings    = $settingsRaw['fields'] ?? $settingsRaw;
		$tabSettings = $settingsRaw['tabs']   ?? [];

		/* -------------- Block Defaults (field values) --------------*/
		$defaultsFile = $configDir . '/defaults.json';
		$defaultsRaw = file_exists($defaultsFile)
			? json_decode(file_get_contents($defaultsFile), true)
			: [];

		$fields = $defaultsRaw['fields'] ?? [];
		if (isset($defaultsRaw['block'])) {
			$defaults = $defaultsRaw['block'];
		} else {
			$defaults = array_merge(
				$defaultsRaw['layout']   ?? [],
				$defaultsRaw['style']    ?? [],
				$defaultsRaw['grid']     ?? [],
				$defaultsRaw['settings'] ?? []
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
		if (!empty($cfg['settings']) && is_array($cfg['settings'])) {
			$settings = array_merge($settings, $cfg['settings']);
		}
		if (!empty($cfg['tabs']) && is_array($cfg['tabs'])) {
			$tabSettings = array_merge($tabSettings, $cfg['tabs']);
		}
		if (!empty($cfg['defaults']) && is_array($cfg['defaults'])) {
			$defaults = array_merge($defaults, $cfg['defaults']);
		}
		if (!empty($cfg['fields']) && is_array($cfg['fields'])) {
			$fields = array_merge($fields, $cfg['fields']);
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
			'settings' => $settings,
			'tabs'     => $tabSettings,
			'defaults' => $defaults,
			'fields'   => $fields,
			'editor'   => $editor,
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
	public static function buildTabs(string $blockType, array $defaults, array $tabSettings, array &$tabs): void
	{
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
		if (!empty($tabSettings['grid']) || !empty($tabSettings['tab-grid'])) {
			$tabs['grid'] = pwGrid::layout($blockType, $gridDefaults);
		} else {
			foreach ($gridDefaults as $key => $value) {
				$tabs['content']['fields'][$key] = ['type' => 'hidden', 'default' => $value];
			}
		}
	}
}
