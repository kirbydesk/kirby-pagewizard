<?php

class pwStyle
{
	public static function options(string $blockType, array $defaults, array $extraFields = []): array
	{
		$fields = [
			'headlineStyle' => ['extends' => 'pagewizard/headlines/style'],
			'style' => [
				'extends' => 'pagewizard/fields/style',
				'width' => '1/1',
				'label'	=> 'pw.headline.theme',
				'default' => $defaults['style']
			],
			'textcolor' => [
				'extends' => 'pagewizard/fields/text-color',
				'when' => [
					'style' => 'custom'
				]
			],
			'backgroundcolor' => [
				'extends' => 'pagewizard/fields/background-color',
				'when' => [
					'style' => 'custom'
				]
			],
			'buttonstyle' => [
				'extends' => 'pagewizard/fields/button-style',
				'when' => [
					'style' => 'custom'
				]
			],
			'headlineBackground' => ['extends' => 'pagewizard/headlines/background'],
			'backgroundSize' => [
				'extends' => 'pagewizard/fields/background-size',
				'default' => $defaults['background-size']
			],
		];

		if (!empty($extraFields)) {
			$fields = array_merge($fields, $extraFields);
		}

		return [
			'label'  => 'pw.tab.style',
			'fields' => $fields,
		];
	}
}
