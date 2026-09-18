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

	return $areas;