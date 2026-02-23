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
			'pattern' => 'pagewizard/icons',
			'action'  => function () {
				$spriteFile = __DIR__ . '/../../assets/icons.svg';
				if (!file_exists($spriteFile)) return [];
				$dom = new DOMDocument();
				$dom->load($spriteFile);
				$icons = [];
				foreach ($dom->getElementsByTagName('symbol') as $symbol) {
					$id    = $symbol->getAttribute('id');
					$vb    = $symbol->getAttribute('viewBox') ?: '0 0 24 24';
					$inner = '';
					foreach ($symbol->childNodes as $child) {
						$inner .= $dom->saveHTML($child);
					}
					$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="' . $vb . '" fill="currentColor" aria-hidden="true">' . trim($inner) . '</svg>';
					$icons[] = [
						'id'    => $id,
						'label' => ucwords(str_replace('-', ' ', $id)),
						'svg'   => $svg,
					];
				}
				return $icons;
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
