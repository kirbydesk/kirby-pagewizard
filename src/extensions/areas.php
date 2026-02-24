<?php

	/* -------------- Areas --------------*/
	$areas = [];
	$areas['divider'] = [
  	'label' => '',
    'icon'  => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"></svg>',
    'menu'  => true,
    'link'  => false,
    'disabled' => true,
	];

	$areas['pw-icons'] = [
		'label' => 'Icons',
		'icon'  => 'image',
		'menu'  => false,
		'views' => [
			[
				'pattern' => 'pagewizard/icons',
				'action'  => fn() => [
					'component' => 'pw-icons-view',
					'title'     => 'Icons',
					'props'     => [],
				],
			],
		],
	];

	return $areas;