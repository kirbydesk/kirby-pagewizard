<?php

class pwTheme
{
	public static function options(string $blockType, array $blockDefaults = []): array
	{
		$fields = [
			'headlineTheme' => [
				'extends' => 'pagewizard/headlines/theme',
			],
			'style' => [
				'extends' => 'pagewizard/fields/style',
				'default' => $blockDefaults['style']
			],
			'backgroundsize' => [
				'extends' => 'pagewizard/fields/background-size',
				'default' => $blockDefaults['backgroundsize']
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
		];

		if (!empty($blockDefaults['buttons'])) {
			$fields['buttonstyle'] = [
				'extends' => 'pagewizard/fields/button-style',
				'when' => [
					'style' => 'custom'
				]
			];
		}

		return [
			'label'  => 'pw.tab.theme',
			'fields' => $fields
		];
	}
}
