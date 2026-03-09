<?php

class pwSettings
{
	public static function options(string $blockType, array $defaults, array $extraFields = [], array $fieldVisibility = []): array
	{
		$fields = [
			'headlineProperties' => ['extends' => 'pagewizard/headlines/properties'],
			'fragment' => [
				'extends' => 'pagewizard/fields/fragment'
			],
			'headlineBlocksettings' => ['extends' => 'pagewizard/headlines/blocksettings'],
			'blockSize' => [
				'extends' => 'pagewizard/fields/block-size',
				'default' => $defaults['block-size']
			],
			'marginTop' => [
				'extends' => 'pagewizard/fields/toggle',
				'default' => $defaults['margin-top'],
				'label' => 'pw.field.margin-top',
				'help' => 'pw.field.margin-top.help'
			],
			'marginBottom' => [
				'extends' => 'pagewizard/fields/toggle',
				'default' => $defaults['margin-bottom'],
				'label' => 'pw.field.margin-bottom',
				'help' => 'pw.field.margin-bottom.help'
			]
		];

		if (isset($fieldVisibility['fragment']) && $fieldVisibility['fragment'] === false) {
			unset($fields['headlineProperties'], $fields['fragment']);
		}
		if (isset($fieldVisibility['block-size']) && $fieldVisibility['block-size'] === false) {
			$fields['blockSize'] = ['type' => 'hidden', 'default' => $defaults['block-size']];
		}
		if (isset($fieldVisibility['margin']) && $fieldVisibility['margin'] === false) {
			$fields['marginTop']['when']    = ['__never__' => 'yes'];
			$fields['marginBottom']['when'] = ['__never__' => 'yes'];
		}
		$blockSizeHidden = isset($fields['blockSize']['type']) && $fields['blockSize']['type'] === 'hidden';
		$marginHidden    = isset($fields['marginTop']['when']);
		if ($blockSizeHidden && $marginHidden) {
			unset($fields['headlineBlocksettings']);
		}

		if (!empty($extraFields)) {
			$fields = array_merge($fields, $extraFields);
		}

		$fields['sharedName'] = ['extends' => 'pagewizard/fields/shared-name'];

		return [
			'label'  => 'pw.tab.settings',
			'fields' => $fields,
		];
	}
}
