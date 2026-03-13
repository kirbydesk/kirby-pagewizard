<?php

class pwStyle
{
	public static function options(string $blockType, array $defaults, array $extraFields = [], array $fieldVisibility = []): array
	{
		$settings = pwConfig::settings($blockType);

		$fields = [
			'headlineStyle' => ['extends' => 'pagewizard/headlines/style'],
			'theme' => [
				'extends' => 'pagewizard/fields/style',
				'width' => '1/1',
				'label'	=> 'pw.headline.theme',
				'default' => $defaults['theme']
			],
			'textcolor' => [
				'extends' => 'pagewizard/fields/text-color',
				'when' => [
					'theme' => 'custom'
				]
			],
			'backgroundcolor' => [
				'extends' => 'pagewizard/fields/background-color',
				'when' => [
					'theme' => 'custom'
				]
			],
		];

		if (!empty($settings['buttons']) || !empty($settings['button'])) {
			$fields['buttonstyle'] = [
				'extends' => 'pagewizard/fields/button-style',
				'when' => [
					'theme' => 'custom'
				]
			];
		}

		if (isset($fieldVisibility['theme']) && $fieldVisibility['theme'] === false) {
			unset($fields['headlineStyle']);
			$fields['theme'] = ['type' => 'hidden', 'default' => $defaults['theme']];
			if (isset($fields['textcolor']))       unset($fields['textcolor']);
			if (isset($fields['backgroundcolor'])) unset($fields['backgroundcolor']);
			if (isset($fields['buttonstyle']))     unset($fields['buttonstyle']);
		}

		if (!empty($extraFields)) {
			$fields = array_merge($fields, $extraFields);
		}

		return [
			'label'  => 'pw.tab.style',
			'fields' => $fields,
		];
	}
}
