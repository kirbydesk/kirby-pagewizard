<?php

	// Heading
	$heading = json_decode($content->heading()->value(), true);

	e(!empty($heading['text']),'<'.$heading['level'].' data-field="heading" data-align="'.$heading['align'].'">'.$heading['text'].'</'.$heading['level'].'>'."\n");