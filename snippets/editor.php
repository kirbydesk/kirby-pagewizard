<?php

// Parse JSON value from pweditor field
$data  = json_decode($content->editor()->value(), true) ?? [];
$mode  = $data['mode'] ?? 'textarea';  // active editor mode: textarea | writer | markdown
$text  = $data[$mode] ?? '';           // text for the active mode
$align = $data['align'] ?? 'left';    // shared alignment

if (!empty($text)):

	// Markdown: render with kirbytext()
	if ($mode === 'markdown'):
		echo '<div data-field="markdown" data-align="'.$align.'">'.kirbytext($text).'</div>'."\n";

	// Textarea / Writer: output as-is
	else:
		echo '<div data-field="'.$mode.'" data-align="'.$align.'">'.$text.'</div>'."\n";

	endif;

endif;
