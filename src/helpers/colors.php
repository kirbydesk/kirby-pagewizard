<?php

/**
 * Get color overrides from config and return as inline style attribute
 *
 * @param string $blockType The block type (e.g., 'pwText', 'pwMedia', 'pwQuote')
 * @return string The style attribute string (e.g., ' style="--pw-color-accent: #FF6B35;"')
 */
function pwGetColorStyles(string $blockType): string
{
	// 1. Global colors (affect all blocks)
	$globalColors = option('kirbydesk.pagewizard.colors', []);

	// 2. Block-specific colors (only for this block type)
	$blockColors = option("kirbydesk.pagewizard.kirbyblocks.{$blockType}.colors", []);

	// Merge: block-specific overrides global
	$configColors = array_merge($globalColors, $blockColors);

	if (empty($configColors)) {
		return '';
	}

	$styles = [];

	if (isset($configColors['primary'])) {
		$styles[] = '--pw-color-primary: ' . $configColors['primary'];
	}
	if (isset($configColors['secondary'])) {
		$styles[] = '--pw-color-secondary: ' . $configColors['secondary'];
	}
	if (isset($configColors['accent'])) {
		$styles[] = '--pw-color-accent: ' . $configColors['accent'];
	}
	if (isset($configColors['background'])) {
		$styles[] = '--pw-color-background: ' . $configColors['background'];
	}
	if (isset($configColors['text'])) {
		$styles[] = '--pw-color-text: ' . $configColors['text'];
	}

	if (empty($styles)) {
		return '';
	}

	return ' style="' . implode('; ', $styles) . ';"';
}
