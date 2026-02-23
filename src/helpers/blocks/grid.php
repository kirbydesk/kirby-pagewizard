<?php

class pwGrid
{
	public static function layout(string $blockType, array $blockDefaults = []): array
	{
		return [
			'label'  => 'pw.tab.grid',
			'fields' => [
				'headlineGrid' => [
					'extends' => 'pagewizard/headlines/grid',
				],
				'gridSizeSm' => [
					'extends' => 'pagewizard/fields/grid-size',
					'default' => $blockDefaults['gridSizeSm'],
					'label' => 'pw.field.grid-size.sm',
					'help' => 'pw.field.grid-size.sm.help'
				],
				'gridOffsetSm' => [
					'extends' => 'pagewizard/fields/grid-offset',
					'default' => $blockDefaults['gridOffsetSm'],
					'label' => 'pw.field.grid-offset.sm',
					'help' => 'pw.field.grid-offset.sm.help'
				],
				'gridSizeMd' => [
					'extends' => 'pagewizard/fields/grid-size',
					'default' => $blockDefaults['gridSizeMd'],
					'label' => 'pw.field.grid-size.md',
					'help' => 'pw.field.grid-size.md.help'
				],
				'gridOffsetMd' => [
					'extends' => 'pagewizard/fields/grid-offset',
					'default' => $blockDefaults['gridOffsetMd'],
					'label' => 'pw.field.grid-offset.md',
					'help' => 'pw.field.grid-offset.md.help'
				],
				'gridSizeLg' => [
					'extends' => 'pagewizard/fields/grid-size',
					'default' => $blockDefaults['gridSizeLg'],
					'label' => 'pw.field.grid-size.lg',
					'help' => 'pw.field.grid-size.lg.help'
				],
				'gridOffsetLg' => [
					'extends' => 'pagewizard/fields/grid-offset',
					'default' => $blockDefaults['gridOffsetLg'],
					'label' => 'pw.field.grid-offset.lg',
					'help' => 'pw.field.grid-offset.lg.help'
				],
				'gridSizeXl' => [
					'extends' => 'pagewizard/fields/grid-size',
					'default' => $blockDefaults['gridSizeXl'],
					'label' => 'pw.field.grid-size.xl',
					'help' => 'pw.field.grid-size.xl.help'
				],
				'gridOffsetXl' => [
					'extends' => 'pagewizard/fields/grid-offset',
					'default' => $blockDefaults['gridOffsetXl'],
					'label' => 'pw.field.grid-offset.xl',
					'help' => 'pw.field.grid-offset.xl.help'
				],
			]
		];
	}
}
