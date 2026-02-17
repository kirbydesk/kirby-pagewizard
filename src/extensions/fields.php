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
	],
	'pwtext' => [
		'extends' => 'text',
		'props' => [
			'align' => function (string $align = null) {
				return $align;
			},
			'level' => function (string $level = null) {
				return $level;
			}
    ]
	],
	'pwtextarea' => [
		'extends' => 'textarea',
		'props' => [
			'align' => function (string $align = null) {
				return $align;
			}
		]
	],
	'pwalign' => [
		'extends' => 'text',
		'props' => [
			'value' => function (string $value = 'left') {
				return $value;
			}
		]
	]
];
