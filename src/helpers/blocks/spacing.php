<?php

class pwSpacing
{
	public static function options(string $blockType, array $blockDefaults = []): array
	{
		// 1. Start with block defaults
		$defaults = [
			'marginTop'    => null,
			'marginBottom' => null,
			'paddingTop'   => null,
			'paddingBottom'=> null,
		];

		// 2. Merge with block-specific defaults from blueprint
		$defaults = array_merge($defaults, $blockDefaults);

		// 3. Override with config values if they exist
		$config = kirby()->option('kirbydesk.pagewizard.kirbyblocks.' . $blockType, []);

		if (!empty($config)) {
			if (isset($config['margin-top']))   	$defaults['marginTop']		= $config['margin-top'];
			if (isset($config['margin-bottom']))	$defaults['marginBottom']	= $config['margin-bottom'];
			if (isset($config['padding-top']))		$defaults['paddingTop']   = $config['padding-top'];
			if (isset($config['padding-bottom']))	$defaults['paddingBottom']= $config['padding-bottom'];
		}

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
					'default' => $defaults['paddingTop'],
					'label' => 'pw.field.padding-top',
					'help' => 'pw.field.padding-top.help'
				],
				'paddingBottom' => [
					'extends' => 'pagewizard/fields/toggle-spacing',
					'default' => $defaults['paddingBottom'],
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
					'default' => $defaults['marginTop'],
					'label' => 'pw.field.margin-top',
					'help' => 'pw.field.margin-top.help'
				],
				'marginBottom' => [
					'extends' => 'pagewizard/fields/toggle-spacing',
					'default' => $defaults['marginBottom'],
					'label' => 'pw.field.margin-bottom',
					'help' => 'pw.field.margin-bottom.help'
				],
			]
		];
	}
}
