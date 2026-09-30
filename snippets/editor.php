<?php

// Parse JSON value from pweditor field
$editorRaw = $content->editor()->value();
$data  = ($editorRaw === null || $editorRaw === '') ? [] : (json_decode($editorRaw, true) ?? []);
$mode  = $data['mode'] ?? 'textarea';  // active editor mode: textarea | writer | markdown
$text  = $data[$mode] ?? '';           // text for the active mode
$align = $data['align'] ?? 'left';    // shared alignment
$size  = $data['size'] ?? 'normal';   // shared size

if (!empty($text)):

	// Markdown: render with kirbytext()
	if ($mode === 'markdown'):
		echo '<div data-field="markdown" data-align="'.$align.'" data-editor-size="'.$size.'">'.kirbytext($text).'</div>'."\n";

	// Textarea: plain text – masked, its line breaks kept
	elseif ($mode === 'textarea'):
		echo '<div data-field="textarea" data-align="'.$align.'" data-editor-size="'.$size.'">'.nl2br(esc($text), false).'</div>'."\n";

	// Writer: its HTML as it is
	else:
		echo '<div data-field="'.$mode.'" data-align="'.$align.'" data-editor-size="'.$size.'">'.$text.'</div>'."\n";

	endif;

endif;
