<?php

class pwLayout
{
	public static function options(string $blockType, array $defaults, array $extraFields = [], array $fieldVisibility = []): array
	{
		$fields = [
			'headlineContentspacing' => ['extends' => 'pagewizard/headlines/contentspacing'],
			'paddingTop' => [
				'extends' => 'pagewizard/fields/toggle',
				'default' => $defaults['padding-top'],
				'label' => 'pw.field.padding-top',
				'help' => 'pw.field.padding-top.help'
			],
			'paddingBottom' => [
				'extends' => 'pagewizard/fields/toggle',
				'default' => $defaults['padding-bottom'],
				'label' => 'pw.field.padding-bottom',
				'help' => 'pw.field.padding-bottom.help'
			],
			'paddingLeft' => [
				'extends' => 'pagewizard/fields/toggle',
				'default' => $defaults['padding-left'],
				'label' => 'pw.field.padding-left',
				'help' => 'pw.field.padding-left.help'
			],
			'paddingRight' => [
				'extends' => 'pagewizard/fields/toggle',
				'default' => $defaults['padding-right'],
				'label' => 'pw.field.padding-right',
				'help' => 'pw.field.padding-right.help'
			],
			'headlineBlockradius' => ['extends' => 'pagewizard/headlines/blockradius'],
			'radiusTopLeft' => [
				'extends' => 'pagewizard/fields/toggle',
				'default' => $defaults['radius-top-left'],
				'label' => 'pw.field.radius-top-left',
				'help' => 'pw.field.radius-top-left.help'
			],
			'radiusTopRight' => [
				'extends' => 'pagewizard/fields/toggle',
				'default' => $defaults['radius-top-right'],
				'label' => 'pw.field.radius-top-right',
				'help' => 'pw.field.radius-top-right.help'
			],
			'radiusBottomLeft' => [
				'extends' => 'pagewizard/fields/toggle',
				'default' => $defaults['radius-bottom-left'],
				'label' => 'pw.field.radius-bottom-left',
				'help' => 'pw.field.radius-bottom-left.help'
			],
			'radiusBottomRight' => [
				'extends' => 'pagewizard/fields/toggle',
				'default' => $defaults['radius-bottom-right'],
				'label' => 'pw.field.radius-bottom-right',
				'help' => 'pw.field.radius-bottom-right.help'
			]
		];

		if (isset($fieldVisibility['padding']) && $fieldVisibility['padding'] === false) {
			unset($fields['headlineContentspacing']);
			$fields['paddingTop']['when']    = ['__never__' => 'yes'];
			$fields['paddingBottom']['when'] = ['__never__' => 'yes'];
			$fields['paddingLeft']['when']   = ['__never__' => 'yes'];
			$fields['paddingRight']['when']  = ['__never__' => 'yes'];
		}

		if (isset($fieldVisibility['radius']) && $fieldVisibility['radius'] === false) {
			unset($fields['headlineBlockradius']);
			$fields['radiusTopLeft']['when']     = ['__never__' => 'yes'];
			$fields['radiusTopRight']['when']    = ['__never__' => 'yes'];
			$fields['radiusBottomLeft']['when']  = ['__never__' => 'yes'];
			$fields['radiusBottomRight']['when'] = ['__never__' => 'yes'];
		}

		if (!empty($extraFields)) {
			$fields = array_merge($fields, $extraFields);
		}

		return [
			'label'  => 'pw.tab.layout',
			'fields' => $fields,
		];
	}
}
