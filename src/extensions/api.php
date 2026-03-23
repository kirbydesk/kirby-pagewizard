<?php

/* -------------- API Routes --------------*/
return [
	'routes' => [
		[
			'pattern' => 'pagewizard/settings/(:any)',
			'action'  => function (string $blockType) {
				$config = pwConfig::load($blockType);
				return ['settings' => $config['content'], 'fields' => $config['fields'], 'defaults' => $config['defaults']];
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
				$config = json_decode(file_get_contents(__DIR__ . '/../../config/defaults.json'), true);
				return [
					'icon-set'      => $config['icon-set'],
					'icon-set-name' => $config['icon-set-name'] ?? $config['icon-set'],
				];
			}
		],
		[
			'pattern' => 'pagewizard/shared',
			'action'  => function () {
				$blocks = site()->sharedblocks()->toBlocks();
				$result = [];
				foreach ($blocks as $block) {
					$name = $block->sharedname()->value();
					$type = $block->type();
					$icon      = 'box';
					$blockName = $type;
					try {
						$bpDef = kirby()->extension('blueprints', 'blocks/' . $type);
						if (is_callable($bpDef)) $bp = $bpDef();
						elseif (is_string($bpDef)) $bp = \Kirby\Data\Data::read($bpDef);
						else $bp = [];
						$icon      = $bp['icon'] ?? 'box';
						$blockName = \Kirby\Toolkit\I18n::translate($bp['name'] ?? $type, $bp['name'] ?? $type);
					} catch (\Throwable $e) {}
					$result[] = [
						'value' => $block->id(),
						'label' => !empty($name) ? $name : $block->id(),
						'type'  => $type,
						'icon'  => $icon,
						'name'  => $blockName,
					];
				}
				return $result;
			}
		],
		[
			'pattern' => 'pagewizard/colors',
			'action'  => function () {
				$publicFile  = kirby()->root('index') . '/assets/css/panel-colors.css';
				$pluginFile  = __DIR__ . '/../../src/panel-colors.css';
				$colorsFile  = file_exists($publicFile) ? $publicFile : $pluginFile;

				if (!file_exists($colorsFile)) {
					return ['default' => [], 'variant' => [], 'variant2' => []];
				}

				$css = file_get_contents($colorsFile);
				$panelColors = ['default' => [], 'variant' => [], 'variant2' => []];

				// :root {} → default colors
				preg_match_all('/:root\s*\{([^}]+)\}/s', $css, $rootBlocks);
				foreach ($rootBlocks[1] as $block) {
					preg_match_all('/--(pw-color-[\w-]+)\s*:\s*([^;]+);/', $block, $vars, PREG_SET_ORDER);
					foreach ($vars as $v) {
						$panelColors['default'][$v[1]] = trim($v[2]);
					}
				}

				// [data-style="X"] {} → theme colors
				foreach (['variant', 'variant2'] as $theme) {
					if (preg_match('/\[data-style="' . $theme . '"\]\s*\{([^}]+)\}/s', $css, $m)) {
						preg_match_all('/--(pw-color-[\w-]+)\s*:\s*([^;]+);/', $m[1], $vars, PREG_SET_ORDER);
						foreach ($vars as $v) {
							$panelColors[$theme][$v[1]] = trim($v[2]);
						}
					}
				}

				return $panelColors;
			}
		]
	]
];
