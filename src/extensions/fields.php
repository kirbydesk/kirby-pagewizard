<?php

return [
	'headline' => [
		'extends' => 'headline',
		'props' => [
			'class' => function (string $class = null) {
				return $class;
			}
		]
		],
	'line' => [
		'extends' => 'line',
		'props' => [
			'class' => function (string $class = null) {
				return $class;
			}
		]
	]
];
