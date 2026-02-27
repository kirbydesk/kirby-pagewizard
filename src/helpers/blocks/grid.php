<?php

class pwGrid
{
	public static function layout(string $blockType, array $defaults = []): array
	{
		return [
			'label'  => 'pw.tab.grid',
			'fields' => [
				'headlineGrid' => [
					'extends' => 'pagewizard/headlines/grid',
				],
				'gridSizeSm' => [
					'extends' => 'pagewizard/fields/grid-size',
					'default' => $defaults['grid-size-sm'],
					'label' => 'pw.field.grid-size.sm',
					'help' => 'pw.field.grid-size.sm.help'
				],
				'gridOffsetSm' => [
					'extends' => 'pagewizard/fields/grid-offset',
					'default' => $defaults['grid-offset-sm'],
					'label' => 'pw.field.grid-offset.sm',
					'help' => 'pw.field.grid-offset.sm.help'
				],
				'gridSizeMd' => [
					'extends' => 'pagewizard/fields/grid-size',
					'default' => $defaults['grid-size-md'],
					'label' => 'pw.field.grid-size.md',
					'help' => 'pw.field.grid-size.md.help'
				],
				'gridOffsetMd' => [
					'extends' => 'pagewizard/fields/grid-offset',
					'default' => $defaults['grid-offset-md'],
					'label' => 'pw.field.grid-offset.md',
					'help' => 'pw.field.grid-offset.md.help'
				],
				'gridSizeLg' => [
					'extends' => 'pagewizard/fields/grid-size',
					'default' => $defaults['grid-size-lg'],
					'label' => 'pw.field.grid-size.lg',
					'help' => 'pw.field.grid-size.lg.help'
				],
				'gridOffsetLg' => [
					'extends' => 'pagewizard/fields/grid-offset',
					'default' => $defaults['grid-offset-lg'],
					'label' => 'pw.field.grid-offset.lg',
					'help' => 'pw.field.grid-offset.lg.help'
				],
				'gridSizeXl' => [
					'extends' => 'pagewizard/fields/grid-size',
					'default' => $defaults['grid-size-xl'],
					'label' => 'pw.field.grid-size.xl',
					'help' => 'pw.field.grid-size.xl.help'
				],
				'gridOffsetXl' => [
					'extends' => 'pagewizard/fields/grid-offset',
					'default' => $defaults['grid-offset-xl'],
					'label' => 'pw.field.grid-offset.xl',
					'help' => 'pw.field.grid-offset.xl.help'
				],
			]
		];
	}
}
