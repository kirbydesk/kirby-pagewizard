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
	'htmlheadline' => [
		'props' => [
			'label' => function ($label = null) {
				return $label;
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
