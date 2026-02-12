<?php

	// Tagline
	$tagline = json_decode($content->tagline()->value(), true);

	if (!empty($tagline['text'])):
		echo '<div data-field="tagline" data-align="'.$tagline['align'].'">'.$tagline['text'].'</div>'."\n";
	endif;