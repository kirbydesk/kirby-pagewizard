<?php

	// Buttons
	if ($content->buttons() && $content->buttons()->isNotEmpty()):
		$items = '';

		// Button
		foreach ($content->buttons()->toBlocks() as $button) :
			$url = '';
			$linktype = $button->linktype()->toBool(); // true = external, false = internal

			// Internal Link
			if (!$linktype && $button->linkinternal()->isNotEmpty()):
				$linkValue = $button->linkinternal()->value();

				try {
					// Page link
					if (Str::startsWith($linkValue, 'page://')):
						$url = $button->linkinternal()->toPage()?->url() ?? '';

					// File link
					elseif (Str::startsWith($linkValue, 'file://')):
						$url = $button->linkinternal()->toFile()?->url() ?? '';

					// Email link
					elseif (Str::startsWith($linkValue, 'mailto:') || Str::startsWith($linkValue, 'email:')):
						$url = Str::startsWith($linkValue, 'mailto:') ? $linkValue : 'mailto:' . Str::after($linkValue, 'email:');

					// Tel link
					elseif (Str::startsWith($linkValue, 'tel:')):
						$url = $linkValue;

					// Anchor link
					elseif (Str::startsWith($linkValue, '#') || Str::startsWith($linkValue, 'anchor:')):
						$url = Str::startsWith($linkValue, '#') ? $linkValue : '#' . Str::after($linkValue, 'anchor:');

					// Fallback
					else:
						$url = $linkValue;
					endif;

				} catch (Exception $e) {
					$url = '';
				}

			// External Link
			elseif ($linktype && $button->linkexternal()->isNotEmpty()):
				$url = $button->linkexternal()->value();
			endif;


			// Build button if URL exists
			if (!empty($url)):
				$linktext = $button->linktext()->isNotEmpty() ? $button->linktext()->value() : t('pw.field.link-text.placeholder');
				$target = '';
				$rel = '';

				// Target and Rel only for external links
				if ($linktype):
					$target = $button->linktarget()->toBool() ? ' target="_blank"' : '';
					$rel = $button->linkrel()->isNotEmpty() ? ' rel="' . $button->linkrel()->value() . '"' : '';
				endif;

				// Aria attributes
				$ariaLabel = $button->arialabel()->isNotEmpty() ? ' aria-label="' . esc($button->arialabel()->value()) . '"' : '';
				$ariaDescribedby = $button->ariadescribedby()->isNotEmpty() ? ' aria-describedby="' . esc($button->ariadescribedby()->value()) . '"' : '';

				$items .= '<div data-field="button"><a href="' . $url . '"' . $target . $rel . $ariaLabel . $ariaDescribedby . '>' . $linktext . '</a></div>' . "\n";
			endif;
		endforeach;


		// Output
		e(!empty($items), '<div data-field="buttons">'.$items.'</div>'."\n");

	endif;