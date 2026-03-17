<?php

class pwStyle
{
	private static array $allThemeOptions = [
		'default'  => ['value' => 'default',  'text' => ['*' => 'pw.option.default']],
		'variant'  => ['value' => 'variant',  'text' => ['*' => 'pw.option.variant']],
		'variant2' => ['value' => 'variant2', 'text' => ['*' => 'pw.option.variant2']],
		'custom'   => ['value' => 'custom',   'text' => ['*' => 'pw.option.custom']],
	];

	public static function options(string $blockType, array $defaults, array $extraFields = [], array $fieldVisibility = []): array
	{
		$settings = pwConfig::settings($blockType);

		$themeField = [
			'extends' => 'pagewizard/fields/style',
			'width'   => '1/1',
			'label'   => 'pw.headline.theme',
			'default' => $defaults['theme']
		];

		$themeConfig = $fieldVisibility['theme'] ?? true;
		if (is_array($themeConfig)) {
			$themeField['options'] = array_values(
				array_intersect_key(self::$allThemeOptions, array_flip($themeConfig))
			);
		}

		$fields = [
			'headlineStyle' => ['extends' => 'pagewizard/headlines/style'],
			'theme' => $themeField,
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

		$customAllowed = !is_array($themeConfig) || in_array('custom', $themeConfig, true);
		if ($customAllowed && (!empty($settings['buttons']) || !empty($settings['button']))) {
			$buttonStyleField = [
				'extends' => 'pagewizard/fields/button-style',
				'when' => ['theme' => 'custom']
			];
			if (is_array($themeConfig)) {
				$buttonThemes = array_values(array_filter($themeConfig, fn($t) => $t !== 'custom'));
				$buttonStyleField['options'] = array_values(
					array_intersect_key(self::$allThemeOptions, array_flip($buttonThemes))
				);
			}
			$fields['buttonstyle'] = $buttonStyleField;
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
