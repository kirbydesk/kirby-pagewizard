<?php

class pwSpacing
{
	public static function options(string $blockType, array $blockDefaults = []): array
	{
		return [
			'label'  => 'pw.tab.spacing',
			'fields' => [
				'headlineSpacing' => [
					'extends' => 'pagewizard/headlines/spacing',
				],
				'headlineInnerspacing' => [
					'type' => 'htmlheadline',
					'class' => 'subheadline',
					'width' => '1/3',
					'label' => 'pw.headline.innerspacing',
					'help' => 'pw.headline.innerspacing.help'
				],
				'paddingTop' => [
					'extends' => 'pagewizard/fields/toggle-spacing',
					'default' => $blockDefaults['paddingTop'],
					'label' => 'pw.field.padding-top',
					'help' => 'pw.field.padding-top.help'
				],
				'paddingBottom' => [
					'extends' => 'pagewizard/fields/toggle-spacing',
					'default' => $blockDefaults['paddingBottom'],
					'label' => 'pw.field.padding-bottom',
					'help' => 'pw.field.padding-bottom.help'
				],
				'headlineOuterspacing' => [
					'type' => 'htmlheadline',
					'class' => 'subheadline',
					'width' => '1/3',
					'label' => 'pw.headline.outerspacing',
					'help' => 'pw.headline.outerspacing.help'
				],
				'marginTop' => [
					'extends' => 'pagewizard/fields/toggle-spacing',
					'default' => $blockDefaults['marginTop'],
					'label' => 'pw.field.margin-top',
					'help' => 'pw.field.margin-top.help'
				],
				'marginBottom' => [
					'extends' => 'pagewizard/fields/toggle-spacing',
					'default' => $blockDefaults['marginBottom'],
					'label' => 'pw.field.margin-bottom',
					'help' => 'pw.field.margin-bottom.help'
				],
			]
		];
	}
}
