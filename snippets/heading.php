<?php

	// Heading
	$heading = json_decode($content->heading()->value(), true);

	if (!empty($heading['text'])):
		echo '<'.$heading['level'].' data-field="heading" data-align="'.$heading['align'].'">'.$heading['text'].'</'.$heading['level'].'>'."\n";
	endif;