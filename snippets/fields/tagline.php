<?php

	// Tagline
	$tagline = json_decode($content->tagline()->value(), true);

	e(!empty($tagline['text']),'<div data-field="tagline" data-align="'.$tagline['align'].'">'.$tagline['text'].'</div>'."\n");