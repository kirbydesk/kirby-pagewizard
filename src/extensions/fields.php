<?php

return [
	'headline' => [
		'extends' => 'headline',
		'props' => [
			'class' => function (?string $class = null) {
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
			'class' => function (?string $class = null) {
				return $class;
			}
		]
	],
	'pwtext' => [
		'extends' => 'text',
		'props' => [
			'align' => function (?string $align = null) {
				return $align;
			},
			'level' => function (?string $level = null) {
				return $level;
			},
			'size' => function (?string $size = null) {
				return $size;
			}
		]
	],
	'pweditor' => [
		'extends' => 'text',
		'props' => [
			'value' => function (?string $value = null) {
				return $value;
			},
			'size' => function (?string $size = null) {
				return $size;
			},
			'fieldHelp' => function (?string $fieldHelp = null) {
				return $fieldHelp;
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
	],
	'pwicon' => [
		'extends' => 'text',
		'props' => [
			'value' => function (?string $value = null) {
				return $value;
			}
		]
	],
	'pwsharedname' => [
		'extends' => 'text',
		'props' => [
			'value' => function (?string $value = null) {
				return $value;
			}
		]
	]
];
