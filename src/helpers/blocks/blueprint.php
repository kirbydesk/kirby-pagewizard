<?php

/**
 * Helper for block blueprint assembly. Deduplicates the repeated boilerplate
 * that every kirbyblock's src/extensions/blueprints.php shares:
 * config load, tabs init, content-tab wrapping, and the standard
 * layout/style/grid/settings tabs.
 *
 * Usage:
 *
 *   return [
 *     'blocks/pwtext' => pwBlueprint::main('pwtext', fn($cfg) => [
 *       'name'          => 'kirbyblock-text.name',
 *       'icon'          => 'text-left',
 *       'contentFields' => pwBlueprint::stdContent($cfg, ['tagline','heading','editor','buttons']),
 *     ]),
 *   ];
 *
 * The builder callback receives the resolved config array from
 * pwConfig::load() and returns the block-specific parts. Everything else
 * (headlineContent header, addTab() calls, blueprint return shape) is
 * handled by main().
 */
class pwBlueprint
{
	/**
	 * Wrap a block builder in the standard blueprint scaffolding.
	 * Returns the closure that Kirby expects as blueprint definition.
	 *
	 * $builder signature: fn(array $config): array $parts
	 *   Required keys in $parts:
	 *     'name'          => blueprint name / label key
	 *     'icon'          => panel icon
	 *     'contentFields' => associative array of Content-Tab fields
	 *                        (headlineContent header is prepended automatically)
	 *   Optional keys:
	 *     'layoutExtras'    => array of extra fields for the Layout tab
	 *     'styleExtras'     => array of extra fields for the Style tab
	 *     'extraTabs'       => ['tabName' => tabDefinition, ...]
	 *                          inserted between Style and Grid, honouring
	 *                          $config['tabs'][$tabName] visibility
	 *     'gridDefault'     => override default visibility for Grid tab (default false)
	 *     'noContentHeader' => when true, do not prepend the standard
	 *                          'headlineContent' header to contentFields
	 *                          (used by blocks with a custom content-tab
	 *                          layout, e.g. multicolumn)
	 */
	public static function main(string $blockName, callable $builder): callable
	{
		return function () use ($blockName, $builder) {
			$config      = pwConfig::load($blockName);
			$tabSettings = $config['tabs'];
			$defaults    = $config['defaults'];
			$parts       = $builder($config);

			$tabs = [];

			// Content Tab
			$contentFields = !empty($parts['noContentHeader'])
				? ($parts['contentFields'] ?? [])
				: array_merge(
					['headlineContent' => ['extends' => 'pagewizard/headlines/content']],
					$parts['contentFields'] ?? []
				);
			$tabs['content'] = [
				'label'  => 'pw.tab.content',
				'fields' => $contentFields,
			];

			// Layout Tab
			pwConfig::addTab(
				$tabs,
				'layout',
				$tabSettings['layout'] ?? true,
				pwLayout::options($blockName, $defaults, $parts['layoutExtras'] ?? [], $config['layout'] ?? [])
			);

			// Style Tab
			pwConfig::addTab(
				$tabs,
				'style',
				$tabSettings['style'] ?? true,
				pwStyle::options($blockName, $defaults, $parts['styleExtras'] ?? [], $config['style'] ?? [])
			);

			// Extra Tabs (e.g. hero's "effects")
			foreach ($parts['extraTabs'] ?? [] as $tabName => $tabDef) {
				pwConfig::addTab(
					$tabs,
					$tabName,
					$tabSettings[$tabName] ?? true,
					$tabDef
				);
			}

			// Grid Tab
			pwConfig::addTab(
				$tabs,
				'grid',
				$tabSettings['grid'] ?? ($parts['gridDefault'] ?? false),
				pwGrid::layout($blockName, $defaults)
			);

			// Settings Tab
			pwConfig::addTab(
				$tabs,
				'settings',
				$tabSettings['settings'] ?? true,
				pwSettings::options($blockName, $defaults, [], $config['settings'] ?? [])
			);

			return [
				'name' => $parts['name'],
				'icon' => $parts['icon'],
				'tabs' => self::hideFields($tabs, $config['hidden'] ?? []),
			];
		};
	}

	/**
	 * Fields hidden from the editors in the Project Wizard (setting keys such
	 * as tagline, padding-top, grid-size-sm): they stay in the block as hidden
	 * fields with their start value, so the frontend keeps using it. A
	 * headline without visible fields goes; a tab without visible fields goes
	 * too, its hidden fields move to the first tab that is left.
	 */
	public static function hideFields(array $tabs, array $hidden): array
	{
		if (empty($hidden)) return $tabs;

		// setting key → field name (padding-top → paddingTop); buttons with their alignment
		$names = [];
		foreach ($hidden as $key) {
			$name = lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $key))));
			$names[$name] = true;
			if ($key === 'buttons') $names['buttonsAlignment'] = true;
		}

		$isHidden = fn($field) => is_array($field) && ($field['type'] ?? null) === 'hidden';
		$moved = [];

		foreach ($tabs as $tabKey => $tab) {
			$fields = [];
			foreach ($tab['fields'] ?? [] as $name => $field) {
				if (isset($names[$name])) {
					$field = array_key_exists('default', (array)$field)
						? ['type' => 'hidden', 'default' => $field['default']]
						: ['type' => 'hidden'];
				}
				$fields[$name] = $field;
			}

			// headlines followed by hidden fields only
			$keys = array_keys($fields);
			foreach ($keys as $i => $name) {
				if (!str_starts_with($name, 'headline')) continue;
				$visible = false;
				for ($j = $i + 1; $j < count($keys) && !str_starts_with($keys[$j], 'headline'); $j++) {
					if (!$isHidden($fields[$keys[$j]])) { $visible = true; break; }
				}
				if (!$visible) unset($fields[$name]);
			}

			// no visible field left: the tab goes, its hidden fields move on
			if (count(array_filter($fields, fn($f) => !$isHidden($f))) === 0) {
				$moved += $fields;
				unset($tabs[$tabKey]);
				continue;
			}
			$tabs[$tabKey]['fields'] = $fields;
		}

		if (!empty($moved)) {
			$first = array_key_first($tabs);
			if ($first !== null) {
				$tabs[$first]['fields'] += $moved;
			} else {
				// every field hidden: one tab keeps them (Kirby needs one)
				$tabs['content'] = ['label' => 'pw.tab.content', 'fields' => $moved];
			}
		}

		return $tabs;
	}

	/**
	 * Assemble standard content-tab fields (tagline/heading/editor/buttons).
	 * Each field is only added when the corresponding content-visibility
	 * flag is enabled in the block's config.
	 *
	 * @param array $config Resolved pwConfig::load() result
	 * @param array $which  Any subset of ['tagline', 'heading', 'editor', 'buttons']
	 * @return array Associative content-fields array (in the order given)
	 */
	public static function stdContent(array $config, array $which): array
	{
		$settings     = $config['content'];
		$fields       = $config['fields'];
		$fieldOptions = $config['field-options'];
		$editor       = $config['editor'] ?? null;

		$out = [];

		foreach ($which as $key) {
			if ($key === 'tagline' && !empty($settings['tagline'])) {
				$out['tagline'] = [
					'extends'      => 'pagewizard/fields/tagline',
					'align'        => $fields['align-tagline'],
					'alignOptions' => $fieldOptions['tagline']['align'] ?? null,
				];
			} elseif ($key === 'heading' && !empty($settings['heading'])) {
				$out['heading'] = [
					'extends'      => 'pagewizard/fields/heading',
					'align'        => $fields['align-heading'],
					'level'        => $fields['level-heading'] ?? null,
					'size'         => $fields['size-heading'] ?? null,
					'sizeOptions'  => $fieldOptions['heading']['sizes'] ?? null,
					'alignOptions' => $fieldOptions['heading']['align'] ?? null,
					'levelOptions' => $fieldOptions['heading']['level'] ?? null,
					'textbackground'        => $fields['textbackground-heading'] ?? null,
					'textbackgroundOptions' => $fieldOptions['heading']['textbackground'] ?? null,
					'multiline'        => $fields['multiline-heading'] ?? null,
					'multilineOptions' => $fieldOptions['heading']['multiline'] ?? null,
					'flourish'         => $fields['flourish-heading'] ?? null,
					'flourishOptions'  => $fieldOptions['heading']['flourish'] ?? null,
				];
			} elseif ($key === 'editor' && !empty($settings['editor'])) {
				$editorField = pwEditor::contentField($editor, $settings);
				$editorField['align']        = $fields['align-editor'] ?? null;
				$editorField['size']         = $fields['size-editor'] ?? null;
				$editorField['alignOptions'] = $fieldOptions['editor']['align'] ?? null;
				$editorField['sizeOptions']  = $fieldOptions['editor']['sizes'] ?? null;
				$editorField['defaultMode']  = $fields['mode-editor'] ?? null;
				$out['editor'] = $editorField;
			} elseif ($key === 'buttons' && !empty($settings['buttons'])) {
				$out['buttonsAlignment'] = [
					'type'         => 'pwalign',
					'align'        => $fields['align-buttons'],
					'default'      => $fields['align-buttons'],
					'alignOptions' => $fieldOptions['buttons']['align'] ?? null,
				];
				$out['buttons'] = ['extends' => 'blocks/pwButtons'];
			}
		}

		return $out;
	}
}
