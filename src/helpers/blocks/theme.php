<?php

class pwTheme
{
	public static function options(string $blockType, array $blockDefaults = []): array
	{
		// 1. Start with block defaults
		$defaults = [
			'theme' => 'default',
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
				'theme' => [
					'extends' => 'pagewizard/fields/style',
					'default' => $defaults['theme']
				]
			]
		];
	}
}
