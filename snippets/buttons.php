<?php

	// Buttons
	if ($content->buttons() && $content->buttons()->isNotEmpty()):
		$items = '';

		// Button
		foreach ($content->buttons()->toBlocks() as $button) :
			ob_start();
			snippet('link', [
				'linkType'        => $button->linktype()->toBool(),
				'linkInternal'    => $button->linkinternal()->value(),
				'linkExternal'    => $button->linkexternal()->value(),
				'linkText'        => $button->linktext()->isNotEmpty() ? $button->linktext()->value() : t('pw.field.link-text.placeholder'),
				'linkTarget'      => $button->linktarget()->toBool(),
				'linkRel'         => $button->linkrel()->value(),
				'ariaLabel'       => $button->arialabel()->value(),
				'ariaDescribedby' => $button->ariadescribedby()->value(),
			]);
			$linkHtml = ob_get_clean();
			if ($linkHtml) :
				$items .= '<div data-field="button">' . $linkHtml . '</div>' . "\n";
			endif;
		endforeach;


		// Output
		$align = $content->buttonsalignment()->isNotEmpty() ? $content->buttonsalignment()->value() : 'left';
		e(!empty($items), '<div data-field="buttons" data-align="'.$align.'">'.$items.'</div>'."\n");

	endif;