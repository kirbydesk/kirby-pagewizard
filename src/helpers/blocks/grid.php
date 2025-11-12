<?php

class pwGrid
{
	public static function layout(string $blockType, array $blockDefaults = []): array
	{
		// 1. Start with block defaults
		$defaults = [
			'gridSizeSm'   => null,
			'gridOffsetSm' => null,
			'gridSizeMd'   => null,
			'gridOffsetMd' => null,
			'gridSizeLg'   => null,
			'gridOffsetLg' => null,
			'gridSizeXl'   => null,
			'gridOffsetXl' => null,
		];

		// 2. Merge with block-specific defaults from blueprint
		$defaults = array_merge($defaults, $blockDefaults);

		// 3. Override with config values if they exist
		$config = kirby()->option('kirbydesk.pagewizard.kirbyblocks.' . $blockType, []);

		if (!empty($config)) {
			if (isset($config['grid-size-sm']))   $defaults['gridSizeSm']   = $config['grid-size-sm'];
			if (isset($config['grid-offset-sm'])) $defaults['gridOffsetSm'] = $config['grid-offset-sm'];
			if (isset($config['grid-size-md']))   $defaults['gridSizeMd']   = $config['grid-size-md'];
			if (isset($config['grid-offset-md'])) $defaults['gridOffsetMd'] = $config['grid-offset-md'];
			if (isset($config['grid-size-lg']))   $defaults['gridSizeLg']   = $config['grid-size-lg'];
			if (isset($config['grid-offset-lg'])) $defaults['gridOffsetLg'] = $config['grid-offset-lg'];
			if (isset($config['grid-size-xl']))   $defaults['gridSizeXl']   = $config['grid-size-xl'];
			if (isset($config['grid-offset-xl'])) $defaults['gridOffsetXl'] = $config['grid-offset-xl'];
		}

		return [
			'label'  => 'pw.tab.grid',
			'fields' => [
				'headlineGrid' => [
					'extends' => 'pagewizard/headlines/grid',
				],
				'headlineSm' => [
					'type' => 'htmlheadline',
					'class' => 'subheadline',
					'label' => 'pw.headline.screen.sm',
					'help' => 'pw.headline.screen.sm.help'
				],
				'gridSizeSm' => [
					'extends' => 'pagewizard/fields/grid-size',
					'default' => $defaults['gridSizeSm'],
					'label' => 'pw.field.grid-size.sm',
					'help' => 'pw.field.grid-size.sm.help'
				],
				'gridOffsetSm' => [
					'extends' => 'pagewizard/fields/grid-offset',
					'default' => $defaults['gridOffsetSm'],
					'label' => 'pw.field.grid-offset.sm',
					'help' => 'pw.field.grid-offset.sm.help'
				],
				'lineSm' => [
					'type' => 'line',
					'class' => 'small',
				],
				'headlineMd' => [
					'type' => 'htmlheadline',
					'class' => 'subheadline',
					'label' => 'pw.headline.screen.md',
					'help' => 'pw.headline.screen.md.help'
				],
				'gridSizeMd' => [
					'extends' => 'pagewizard/fields/grid-size',
					'default' => $defaults['gridSizeMd'],
					'label' => 'pw.field.grid-size.md',
					'help' => 'pw.field.grid-size.md.help'
				],
				'gridOffsetMd' => [
					'extends' => 'pagewizard/fields/grid-offset',
					'default' => $defaults['gridOffsetMd'],
					'label' => 'pw.field.grid-offset.md',
					'help' => 'pw.field.grid-offset.md.help'
				],
				'lineMd' => [
					'type' => 'line',
					'class' => 'small',
				],
				'headlineLg' => [
					'type' => 'htmlheadline',
					'class' => 'subheadline',
					'label' => 'pw.headline.screen.lg',
					'help' => 'pw.headline.screen.lg.help'
				],
				'gridSizeLg' => [
					'extends' => 'pagewizard/fields/grid-size',
					'default' => $defaults['gridSizeLg'],
					'label' => 'pw.field.grid-size.lg',
					'help' => 'pw.field.grid-size.lg.help'
				],
				'gridOffsetLg' => [
					'extends' => 'pagewizard/fields/grid-offset',
					'default' => $defaults['gridOffsetLg'],
					'label' => 'pw.field.grid-offset.lg',
					'help' => 'pw.field.grid-offset.lg.help'
				],
				'lineLg' => [
					'type' => 'line',
					'class' => 'small',
				],
				'headlineXl' => [
					'type' => 'htmlheadline',
					'class' => 'subheadline',
					'label' => 'pw.headline.screen.xl',
					'help' => 'pw.headline.screen.xl.help'
				],
				'gridSizeXl' => [
					'extends' => 'pagewizard/fields/grid-size',
					'default' => $defaults['gridSizeXl'],
					'label' => 'pw.field.grid-size.xl',
					'help' => 'pw.field.grid-size.xl.help'
				],
				'gridOffsetXl' => [
					'extends' => 'pagewizard/fields/grid-offset',
					'default' => $defaults['gridOffsetXl'],
					'label' => 'pw.field.grid-offset.xl',
					'help' => 'pw.field.grid-offset.xl.help'
				],
			]
		];
	}
}
