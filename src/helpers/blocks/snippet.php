<?php

/**
 * Helper for block-level snippet rendering. Deduplicates the standard
 * <section> and grid <div> markup that every kirbyblock-* renders,
 * so snippets can focus on block-specific content.
 */
class pwSnippet
{
	/**
	 * Render the opening <section> tag with all standard data-attributes:
	 * data-block, data-block-id, data-margin/padding/radius-*, data-style,
	 * data-block-size, optional data-button-style (custom theme) and
	 * optional id (from the fragment field).
	 *
	 * @param string $blockName  Value for data-block (e.g. "text", "hero")
	 * @param object $block      Kirby block instance
	 * @param array  $settings   Content settings from pwConfig::load()
	 * @param string $extraAttrs Raw string of additional attributes to append
	 *                           BEFORE the closing '>'. Use e.g. for
	 *                           block-specific data-* like data-height,
	 *                           data-background-type, or inline style.
	 *                           Must start with a leading space.
	 */
	public static function sectionOpen(string $blockName, $block, array $settings = [], string $extraAttrs = ''): string
	{
		$out  = '<section';
		$out .= ' data-block="' . $blockName . '"';
		$out .= ' data-block-id="b' . $block->id() . '"';
		$out .= ' data-margin-top="' . $block->margintop()->value() . '"';
		$out .= ' data-margin-bottom="' . $block->marginbottom()->value() . '"';
		$out .= ' data-padding-top="' . $block->paddingtop()->value() . '"';
		$out .= ' data-padding-right="' . ($block->paddingright()->toBool() ? 'true' : 'false') . '"';
		$out .= ' data-padding-bottom="' . $block->paddingbottom()->value() . '"';
		$out .= ' data-padding-left="' . ($block->paddingleft()->toBool() ? 'true' : 'false') . '"';
		$out .= ' data-radius-top-left="' . ($block->radiustopleft()->toBool() ? 'true' : 'false') . '"';
		$out .= ' data-radius-top-right="' . ($block->radiustopright()->toBool() ? 'true' : 'false') . '"';
		$out .= ' data-radius-bottom-right="' . ($block->radiusbottomright()->toBool() ? 'true' : 'false') . '"';
		$out .= ' data-radius-bottom-left="' . ($block->radiusbottomleft()->toBool() ? 'true' : 'false') . '"';
		$out .= ' data-style="' . $block->theme()->value() . '"';
		$out .= ' data-block-size="' . $block->blocksize()->value() . '"';

		// data-button-style only when custom theme and non-default button style
		if (
			!empty($settings['buttons'])
			&& $block->content()->theme()->value() === 'custom'
			&& $block->buttonstyle()->value() !== 'default'
		) {
			$out .= ' data-button-style="' . $block->buttonstyle()->value() . '"';
		}

		// id="fragment" when the block has a fragment anchor set
		if ($block->fragment()->isNotEmpty()) {
			$out .= ' id="' . $block->fragment()->value() . '"';
		}

		// Extra attributes (block-specific: data-height, data-background-type, ...)
		if ($extraAttrs !== '') {
			$out .= $extraAttrs;
		}

		$out .= '>' . "\n";
		return $out;
	}

	/**
	 * Render the opening grid wrapper:
	 * <div data-layout="grid"><div data-layout="grid-item" data-grid-*="...">
	 */
	public static function gridOpen($block): string
	{
		$out  = '<div data-layout="grid"><div data-layout="grid-item"';
		$out .= ' data-grid-size-sm="' . $block->gridsizesm()->value() . '"';
		$out .= ' data-grid-size-md="' . $block->gridsizemd()->value() . '"';
		$out .= ' data-grid-size-lg="' . $block->gridsizelg()->value() . '"';
		$out .= ' data-grid-size-xl="' . $block->gridsizexl()->value() . '"';
		$out .= ' data-grid-offset-sm="' . $block->gridoffsetsm()->value() . '"';
		$out .= ' data-grid-offset-md="' . $block->gridoffsetmd()->value() . '"';
		$out .= ' data-grid-offset-lg="' . $block->gridoffsetlg()->value() . '"';
		$out .= ' data-grid-offset-xl="' . $block->gridoffsetxl()->value() . '"';
		$out .= '>' . "\n";
		return $out;
	}

	/**
	 * Close the grid wrapper opened by gridOpen().
	 */
	public static function gridClose(): string
	{
		return '</div></div>' . "\n";
	}

	/**
	 * Close the section opened by sectionOpen().
	 */
	public static function sectionClose(): string
	{
		return '</section>' . "\n";
	}

	/**
	 * Render the customcss snippet for custom-theme blocks
	 * (inline CSS with the block's textcolor/backgroundcolor).
	 * No-op if theme is not "custom".
	 */
	public static function customCss($block): void
	{
		if ($block->content()->theme()->value() !== 'custom') return;
		snippet('customcss', [
			'blockid'         => 'b' . $block->id(),
			'textcolor'       => $block->content()->textcolor()->value(),
			'backgroundcolor' => $block->content()->backgroundcolor()->value(),
		]);
	}
}
