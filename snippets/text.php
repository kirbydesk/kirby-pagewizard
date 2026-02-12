<?php


// Text Mode: Textarea
if ($content->textmode()->value() == 'textarea'):
	$obj = json_decode($content->texttextarea()->value(), true);
	if (!empty($obj['text'])):
		echo '<div data-field="textarea" data-align="'.$obj['align'].'">'.$obj['text'].'</div>'."\n";
	endif;


// Text Mode: Writer
elseif ($content->textmode()->value() == 'writer'):
	if ($content->textwriter()->isNotEmpty()):
		echo '<div data-field="writer">'.$content->textwriter()->value().'</div>'."\n";
	endif;


// Text Mode: Markdown
elseif ($content->textmode()->value() == 'markdown'):
	if ($content->textmarkdown()->isNotEmpty()):
		echo '<div data-field="markdown">'.$content->textmarkdown()->kt().'</div>'."\n";
	endif;


endif;