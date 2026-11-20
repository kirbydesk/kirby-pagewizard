<?php

	// Tagline
	$taglineRaw = $content->tagline()->value();
	$tagline = ($taglineRaw === null || $taglineRaw === '') ? [] : (json_decode($taglineRaw, true) ?? []);

	if (!empty($tagline['text'])):
		// (its line above it: Project Wizard › Elements › Tagline, the form per block)
		echo '<div data-field="tagline" data-align="'.($tagline['align'] ?? 'left').'"'.pwConfig::taglineLeadline($tagline).'>'.$tagline['text'].'</div>'."\n";
	endif;