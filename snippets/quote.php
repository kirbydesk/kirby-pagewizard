<?php

	$quote 	= json_decode($content->textquote()->value(), true);
	$author = json_decode($content->author()->value(), true);

	if (!empty($quote['text'])):

		// Quote
		echo '<figure>'."\n";
		echo '<blockquote data-field="quote" data-align="'.$quote['align'].'">'.$quote['text'].'</blockquote>'."\n";

		// Author
		if (!empty($author['text'])):
			echo '<figcaption data-field="author" data-align="'.$author['align'].'">'.$author['text'].'</figcaption>'."\n";
		endif;

		echo '</figure>'."\n";

	endif;