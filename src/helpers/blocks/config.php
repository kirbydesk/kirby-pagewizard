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
	 * Build common tabs (grid, spacing, theme) and add them to $tabs.
	 */
	public static function buildTabs(string $blockType, array $defaults, array $tabSettings, array &$tabs): void
	{
		/* -------------- Grid Tab --------------*/
		$enabled = !empty($tabSettings['grid']) || !empty($tabSettings['tab-grid']);
		self::addTab($tabs, 'grid', $enabled, pwGrid::layout($blockType, $defaults));
	}
}
