<?php

class pwTheme
{
	public static function options(string $blockType, array $blockDefaults = []): array
	{
		// 1. Start with block defaults
		$defaults = [
			'style' => 'default',
		];

		// 2. Merge with block-specific defaults from blueprint
		$defaults = array_merge($defaults, $blockDefaults);

		// 3. Override with config values if they exist
		$config = kirby()->option('kirbydesk.pagewizard.kirbyblocks.' . $blockType, []);
		if (!empty($config) && isset($config['theme'])) {
			$defaults['theme'] = $config['theme'];
		}

		return [
			'label'  => 'pw.tab.theme',
			'fields' => [
				'headlineTheme' => [
					'extends' => 'pagewizard/headlines/theme',
				],
				'style' => [
					'extends' => 'pagewizard/fields/style',
					'default' => $defaults['style']
				],
				'backgroundsize' => [
					'extends' => 'pagewizard/fields/background-size',
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
				]
			]
		];
	}
}
