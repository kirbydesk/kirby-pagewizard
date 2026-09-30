<?php

return [
	// the pages' blocks field: Kirby's own, as a type of its own
	'pwblocks' => PwblocksField::class,
	// a heading over values per screen size, with the sizes as pills
	'pwbreakpoints' => [
		'extends' => 'headline',
		'props'   => [
			'group' => fn (string $group = 'columns') => $group,
		],
		// the help of each size (shown for the chosen pill instead of the
		// heading's own)
		'computed' => [
			'sizeHelps' => function () {
				$helps = [];
				foreach (['sm', 'md', 'lg', 'xl'] as $bp) {
					$helps[$bp] = $this->kirby()->kirbytext(\Kirby\Toolkit\I18n::translate('pw.headline.screen.' . $bp . '.help'));
				}
				return $helps;
			},
		],
	],
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
			},
			'textbackground' => function (?string $textbackground = null) {
				return $textbackground;
			},
			'multiline' => function (?string $multiline = null) {
				return $multiline;
			},
			'flourish' => function (?string $flourish = null) {
				return $flourish;
			},
			'alignOptions' => function ($alignOptions = null) {
				return $alignOptions;
			},
			'levelOptions' => function ($levelOptions = null) {
				return $levelOptions;
			},
			'sizeOptions' => function ($sizeOptions = null) {
				return $sizeOptions;
			},
			'textbackgroundOptions' => function ($textbackgroundOptions = null) {
				return $textbackgroundOptions;
			},
			'multilineOptions' => function ($multilineOptions = null) {
				return $multilineOptions;
			},
			'flourishOptions' => function ($flourishOptions = null) {
				return $flourishOptions;
			}
		]
	],
	'pweditor' => [
		'extends' => 'text',
		'props' => [
			'value' => function (?string $value = null) {
				return $value;
			},
			'align' => function (?string $align = null) {
				return $align;
			},
			'size' => function (?string $size = null) {
				return $size;
			},
			'alignOptions' => function ($alignOptions = null) {
				return $alignOptions;
			},
			'sizeOptions' => function ($sizeOptions = null) {
				return $sizeOptions;
			},
			'defaultMode' => function (?string $defaultMode = null) {
				return $defaultMode;
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
