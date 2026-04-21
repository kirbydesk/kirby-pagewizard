<?php

	// Heading
	$headingRaw = $content->heading()->value();
	$heading = ($headingRaw === null || $headingRaw === '') ? [] : (json_decode($headingRaw, true) ?? []);

	if (!empty($heading['text'])):
		$tb = ($heading['textbackground'] ?? null) === 'enabled';
		echo '<'.$heading['level'].' data-field="heading" data-heading-size="'.($heading['size'] ?? null).'" data-align="'.($heading['align'] ?? null).'">';
		if ($tb) echo '<span data-textbackground>';
		echo $heading['text'];
		if ($tb) echo '</span>';
		echo '</'.$heading['level'].'>'."\n";
	endif;