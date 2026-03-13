<?php

	// Tagline
	$taglineRaw = $content->tagline()->value();
	$tagline = ($taglineRaw === null || $taglineRaw === '') ? [] : (json_decode($taglineRaw, true) ?? []);

	if (!empty($tagline['text'])):
		echo '<div data-field="tagline" data-align="'.$tagline['align'].'">'.$tagline['text'].'</div>'."\n";
	endif;