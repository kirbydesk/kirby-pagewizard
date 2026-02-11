<?php


// Text Mode: Textarea
if ($content->textmode()->value() == 'textarea'):
	$obj = json_decode($content->texttextarea()->value(), true);
	e(!empty($obj['text']),'<div data-field="textarea" data-align="'.$obj['align'].'">'.$obj['text'].'</div>'."\n");


// Text Mode: Writer
elseif ($content->textmode()->value() == 'writer'):
	e(!empty($content->textwriter()),'<div data-field="writer">'.$content->textwriter()->value().'</div>'."\n");


// Text Mode: Markdown
elseif ($content->textmode()->value() == 'markdown'):
	e(!empty($content->textmarkdown()),'<div data-field="markdown">'.$content->textmarkdown()->kt().'</div>'."\n");


endif;