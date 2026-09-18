<?php

	/* -------------- Areas --------------*/
	$areas = [];
	$areas['divider'] = [
		'label'    => '',
		'icon'     => 'blank',
		'menu'     => true,
		'link'     => false,
		'disabled' => true,
	];

	$areas['pw-icons'] = fn() => [
		'label' => t('pw.icon.title', 'Icons'),
		'icon'  => 'image',
		'menu'  => false,
		'views' => [
			[
				'pattern' => 'pagewizard/icons',
				'action'  => fn() => [
					'component' => 'pw-icons-view',
					'title'     => t('pw.icon.title', 'Icons'),
					'props'     => [],
				],
			],
		],
	];

	/* -------------- AI view button --------------*/
	// Shared "AI" button for page/site views. The entries come from the
	// installed AI plugins, each exposing an `aiActions` option:
	//   fn(ModelWithContent $model): array  — Kirby dropdown items
	// The button only appears when at least one plugin has entries for
	// the current view; groups of different plugins are separated by a line.
	$areas['site'] = fn() => [
		'buttons' => [
			'ai' => function ($model = null) {
				if ($model === null) return null;

				$kirby  = kirby();
				$groups = [];
				foreach (['kirbydesk.translatewizard', 'kirbydesk.contentwizard'] as $plugin) {
					$actions = $kirby->option($plugin . '.aiActions');
					if (!is_callable($actions)) continue;

					$items = $actions($model);
					if (!empty($items)) $groups[] = $items;
				}

				if ($groups === []) return null;

				$options = [];
				foreach ($groups as $i => $items) {
					if ($i > 0) $options[] = '-';
					array_push($options, ...$items);
				}

				return [
					'icon'    => 'ai',
					'title'   => t('pw.ai.button', 'AI'),
					'options' => $options,
				];
			},
		],
	];

	return $areas;