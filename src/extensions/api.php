<?php

/* -------------- API Routes --------------*/
return [
	'routes' => [
		/* -------------- API keys of the AI plugins (.env) — admins only --------------*/
		[
			'pattern' => 'pagewizard/secrets',
			'method'  => 'GET',
			'action'  => function () {
				if (!pwSecrets::allowed()) throw new Kirby\Exception\PermissionException(message: 'Not allowed.');
				return ['secrets' => pwSecrets::status(), 'writable' => is_writable(is_file(pwSecrets::file()) ? pwSecrets::file() : dirname(pwSecrets::file()))];
			}
		],
		[
			'pattern' => 'pagewizard/secrets',
			'method'  => 'POST',
			'action'  => function () {
				if (!pwSecrets::allowed()) throw new Kirby\Exception\PermissionException(message: 'Not allowed.');

				$input  = kirby()->request()->body()->toArray();
				$labels = array_column(pwSecrets::declared(), 'label', 'env');

				// set: {ENV: "new key"} — empty values keep the stored key
				foreach ((array) ($input['set'] ?? []) as $env => $value) {
					if (!is_string($value) || trim($value) === '' || !pwSecrets::isDeclared((string) $env)) continue;
					pwSecrets::write((string) $env, $value, $labels[$env] ?? '');
				}
				// remove: ["ENV", …]
				foreach ((array) ($input['remove'] ?? []) as $env) {
					if (is_string($env) && pwSecrets::isDeclared($env)) pwSecrets::write($env, '');
				}

				return ['secrets' => pwSecrets::status(), 'writable' => true];
			}
		],
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
					return ['default' => [], 'variant' => [], 'variant2' => [], 'variant3' => []];
				}

				$css = file_get_contents($colorsFile);
				$panelColors = ['default' => [], 'variant' => [], 'variant2' => [], 'variant3' => []];

				// :root {} → default colors (all pw-color-* and plugin-specific pw*-item-*)
				preg_match_all('/:root\s*\{([^}]+)\}/s', $css, $rootBlocks);
				foreach ($rootBlocks[1] as $block) {
					preg_match_all('/--(pw[\w-]+)\s*:\s*([^;]+);/', $block, $vars, PREG_SET_ORDER);
					foreach ($vars as $v) {
						$panelColors['default'][$v[1]] = trim($v[2]);
					}
				}

				// [data-style="X"] {} → theme colors
				foreach (['variant', 'variant2', 'variant3'] as $theme) {
					preg_match_all('/\[data-style="' . $theme . '"\]\s*\{([^}]+)\}/s', $css, $matches);
					foreach ($matches[1] as $block) {
						preg_match_all('/--(pw[\w-]+)\s*:\s*([^;]+);/', $block, $vars, PREG_SET_ORDER);
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
