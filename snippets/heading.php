<?php

	// Heading
	$heading = json_decode($content->heading()->value(), true);

	if (!empty($heading['text'])):
		echo '<'.$heading['level'].' data-field="heading" data-size="'.($heading['size'] ?? null).'" data-align="'.($heading['align'] ?? null).'">'.$heading['text'].'</'.$heading['level'].'>'."\n";
	endif;