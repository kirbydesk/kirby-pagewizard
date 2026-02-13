<?php

/* -------------- API Routes --------------*/
return [
	'routes' => [
		[
			'pattern' => 'pagewizard/settings/(:any)',
			'action'  => function (string $blockType) {
				return ['settings' => pwConfig::settings($blockType)];
			}
		]
	]
];
