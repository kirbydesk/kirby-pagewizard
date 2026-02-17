<?php

class pwLayout
{
	public static function options(string $blockType, array $defaults, array $extraFields = []): array
	{
		$fields = [
			'headlineContentspacing' => ['extends' => 'pagewizard/headlines/contentspacing'],
			'paddingTop' => [
				'extends' => 'pagewizard/fields/toggle-spacing',
				'default' => $defaults['padding-top'],
				'label' => 'pw.field.padding-top',
				'help' => 'pw.field.padding-top.help'
			],
			'paddingBottom' => [
				'extends' => 'pagewizard/fields/toggle-spacing',
				'default' => $defaults['padding-bottom'],
				'label' => 'pw.field.padding-bottom',
				'help' => 'pw.field.padding-bottom.help'
			],
			'paddingLeft' => [
				'extends' => 'pagewizard/fields/toggle-spacing',
				'default' => $defaults['padding-left'],
				'label' => 'pw.field.padding-left',
				'help' => 'pw.field.padding-left.help'
			],
			'paddingRight' => [
				'extends' => 'pagewizard/fields/toggle-spacing',
				'default' => $defaults['padding-right'],
				'label' => 'pw.field.padding-right',
				'help' => 'pw.field.padding-right.help'
			],
		];

		if (!empty($extraFields)) {
			$fields = array_merge($fields, $extraFields);
		}

		return [
			'label'  => 'pw.tab.layout',
			'fields' => $fields,
		];
	}
}
