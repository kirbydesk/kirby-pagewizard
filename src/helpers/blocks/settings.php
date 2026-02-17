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
			'marginTop' => [
				'extends' => 'pagewizard/fields/toggle-spacing',
				'default' => $defaults['margin-top'],
				'width' => '1/2',
				'label' => 'pw.field.margin-top',
				'help' => 'pw.field.margin-top.help'
			],
			'marginBottom' => [
				'extends' => 'pagewizard/fields/toggle-spacing',
				'default' => $defaults['margin-bottom'],
				'width' => '1/2',
				'label' => 'pw.field.margin-bottom',
				'help' => 'pw.field.margin-bottom.help'
			],
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
