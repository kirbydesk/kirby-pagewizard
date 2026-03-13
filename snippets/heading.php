<?php

	// Heading
	$headingRaw = $content->heading()->value();
	$heading = ($headingRaw === null || $headingRaw === '') ? [] : (json_decode($headingRaw, true) ?? []);

	if (!empty($heading['text'])):
		echo '<'.$heading['level'].' data-field="heading" data-heading-size="'.($heading['size'] ?? null).'" data-align="'.($heading['align'] ?? null).'">'.$heading['text'].'</'.$heading['level'].'>'."\n";
	endif;