<?php

class pwSettings
{
	public static function options(string $blockType, array $defaults, array $extraFields = []): array
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
				'extends' => 'pagewizard/fields/toggle-spacing',
				'default' => $defaults['margin-top'],
				'label' => 'pw.field.margin-top',
				'help' => 'pw.field.margin-top.help'
			],
			'marginBottom' => [
				'extends' => 'pagewizard/fields/toggle-spacing',
				'default' => $defaults['margin-bottom'],
				'label' => 'pw.field.margin-bottom',
				'help' => 'pw.field.margin-bottom.help'
			]
		];

		if (!empty($extraFields)) {
			$fields = array_merge($fields, $extraFields);
		}

		return [
			'label'  => 'pw.tab.settings',
			'fields' => $fields,
		];
	}
}
