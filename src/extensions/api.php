<?php

/* -------------- API Routes --------------*/
return [
	'routes' => [
		[
			'pattern' => 'pagewizard/settings/(:any)',
			'action'  => function (string $blockType) {
				$config = pwConfig::load($blockType);
				return ['settings' => $config['settings'], 'fields' => $config['fields']];
			}
		],
		[
			'pattern' => 'pagewizard/colors',
			'action'  => function () {
				$colorsFile = kirby()->root('temp') . '/pw-colors.json';
				if (file_exists($colorsFile)) {
					return json_decode(file_get_contents($colorsFile), true);
				}
				return ['default' => [], 'variant' => []];
			}
		]
	]
];
