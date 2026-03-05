<?php

	// Heading
	$heading = json_decode($content->heading()->value(), true);

	if (!empty($heading['text'])):
		echo '<'.$heading['level'].' data-field="heading" data-heading-size="'.($heading['size'] ?? null).'" data-align="'.($heading['align'] ?? null).'">'.$heading['text'].'</'.$heading['level'].'>'."\n";
	endif;