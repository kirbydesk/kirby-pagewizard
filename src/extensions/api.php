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
			'pattern' => 'pagewizard/icons/sets',
			'action'  => function () {
				$iconsDir = __DIR__ . '/../../assets/icons/';
				if (!is_dir($iconsDir)) return [];
				$sets = [];
				foreach (glob($iconsDir . '*.svg') as $file) {
					$sets[] = basename($file, '.svg');
				}
				return $sets;
			}
		],
		[
			'pattern' => 'pagewizard/icons/(:any)',
			'action'  => function (string $set) {
				$iconsDir = __DIR__ . '/../../assets/icons/';

				$parseSprite = function (string $name) use ($iconsDir) {
					$path = $iconsDir . $name . '.svg';
					if (!file_exists($path)) return [];
					$dom = new DOMDocument();
					$dom->load($path);
					$icons = [];
					foreach ($dom->getElementsByTagName('symbol') as $symbol) {
						$id    = $symbol->getAttribute('id');
						$vb    = $symbol->getAttribute('viewBox') ?: '0 0 24 24';
						$fill  = $symbol->getAttribute('fill') ?: 'currentColor';
						$inner = '';
						foreach ($symbol->childNodes as $child) {
							$inner .= $dom->saveHTML($child);
						}
						$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="' . $vb . '" fill="' . $fill . '" aria-hidden="true" data-icon="' . $id . '">' . trim($inner) . '</svg>';
						$icons[] = [
							'id'     => $id,
							'label'  => ucwords(str_replace(['-', '_'], ' ', $id)),
							'svg'    => $svg,
							'custom' => false,
						];
					}
					return $icons;
				};

				// Load base set
				$icons = $parseSprite($set);

				// Merge custom icons on top (only when loading a non-custom set)
				if ($set !== 'custom') {
					$custom = $parseSprite('custom');
					foreach ($custom as &$icon) {
						$icon['custom'] = true;
					}
					$icons = array_merge($custom, $icons);
				}

				return $icons;
			}
		],
		[
			'pattern' => 'pagewizard/config',
			'action'  => function () {
				$defaults = json_decode(file_get_contents(__DIR__ . '/../../config/defaults.json'), true);
				$project  = kirby()->option('kirbydesk.pagewizard', []);
				$config   = array_merge($defaults, $project);
				return [
					'icon-set'      => $config['icon-set'],
					'icon-set-name' => $config['icon-set-name'] ?? $config['icon-set'],
				];
			}
		],
		[
			'pattern' => 'pagewizard/colors',
			'action'  => function () {
				$patchFile   = kirby()->root('site') . '/patches/css/kirby-pagewizard/01-colors.css';
				$defaultFile = __DIR__ . '/../../src/css/01-colors.css';
				$colorsFile  = file_exists($patchFile) ? $patchFile : (file_exists($defaultFile) ? $defaultFile : null);

				if (!$colorsFile) {
					return ['default' => [], 'variant' => []];
				}

				$css = file_get_contents($colorsFile);
				$panelColors = ['default' => [], 'variant' => []];

				// Parse alle :root Blöcke → default
				preg_match_all('/:root\s*\{([^}]+)\}/s', $css, $rootBlocks);
				foreach ($rootBlocks[1] as $block) {
					preg_match_all('/--(pw-color-[\w-]+)\s*:\s*([^;]+);/', $block, $vars, PREG_SET_ORDER);
					foreach ($vars as $v) {
						$panelColors['default'][$v[1]] = trim($v[2]);
					}
				}

				// Parse section[data-style="variant"] Block → variant
				if (preg_match('/section\[data-style="variant"\]\s*\{([^}]+)\}/s', $css, $m)) {
					preg_match_all('/--(pw-color-[\w-]+)\s*:\s*([^;]+);/', $m[1], $vars, PREG_SET_ORDER);
					foreach ($vars as $v) {
						$panelColors['variant'][$v[1]] = trim($v[2]);
					}
				}

				// Parse variant button colors (multi-selector block)
				if (preg_match('/section\[data-style="variant"\],\s*\n\s*section\[data-style="custom"\]\[data-button-style="variant"\]\s*\{([^}]+)\}/s', $css, $m)) {
					preg_match_all('/--(pw-color-[\w-]+)\s*:\s*([^;]+);/', $m[1], $vars, PREG_SET_ORDER);
					foreach ($vars as $v) {
						$panelColors['variant'][$v[1]] = trim($v[2]);
					}
				}

				return $panelColors;
			}
		]
	]
];
