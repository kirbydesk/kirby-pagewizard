<?php

	// Heading
	$headingRaw = $content->heading()->value();
	$heading = ($headingRaw === null || $headingRaw === '') ? [] : (json_decode($headingRaw, true) ?? []);

	if (!empty($heading['text'])):
		$tb        = ($heading['textbackground'] ?? null) === 'enabled';
		$multiline = ($heading['multiline'] ?? null) === 'enabled';
		$flourish  = ($heading['flourish'] ?? null) === 'enabled';
		echo '<'.$heading['level'].' data-field="heading" data-heading-size="'.($heading['size'] ?? null).'" data-align="'.($heading['align'] ?? null).'">';
		if ($multiline) {
			// Split on newlines, render each line in its own <span> so that
			// textbackground (if enabled) produces one clean box per line
			// without box-decoration-break inconsistencies across renderers.
			$lines = preg_split('/\r\n|\r|\n/', $heading['text']);
			$out = [];
			foreach ($lines as $line) {
				if ($line === '') continue;
				$out[] = $tb
					? '<span data-textbackground>' . $line . '</span>'
					: '<span>' . $line . '</span>';
			}
			echo implode('<br>', $out);
		} else {
			if ($tb) echo '<span data-textbackground>';
			echo $heading['text'];
			if ($tb) echo '</span>';
		}
		echo '</'.$heading['level'].'>'."\n";
		if ($flourish) {
			echo '<div data-flourish data-align="'.($heading['align'] ?? null).'"></div>'."\n";
		}
	endif;