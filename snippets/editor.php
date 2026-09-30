<?php

// Parse JSON value from pweditor field
$editorRaw = $content->editor()->value();
$data  = ($editorRaw === null || $editorRaw === '') ? [] : (json_decode($editorRaw, true) ?? []);
$mode  = $data['mode'] ?? 'textarea';  // active editor mode: textarea | writer
$text  = $data[$mode] ?? '';           // text for the active mode
$align = $data['align'] ?? 'left';    // shared alignment
$size  = $data['size'] ?? 'normal';   // shared size

if (!empty($text)):

	// Writer: its HTML as it is
	if ($mode === 'writer'):
		echo '<div data-field="writer" data-align="'.$align.'" data-editor-size="'.$size.'">'.$text.'</div>'."\n";

	// Textarea: plain text – masked, its line breaks kept
	else:
		echo '<div data-field="textarea" data-align="'.$align.'" data-editor-size="'.$size.'">'.nl2br(esc($text), false).'</div>'."\n";

	endif;

endif;
