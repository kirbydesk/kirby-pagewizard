<?php

$quoteRaw  = $content->quote()->value();
$authorRaw = $content->author()->value();

$quote  = ($quoteRaw === null || $quoteRaw === '') ? [] : (json_decode($quoteRaw, true) ?? []);
$author = ($authorRaw === null || $authorRaw === '') ? [] : (json_decode($authorRaw, true) ?? []);


$quoteText = $quote['textarea'] ?? '';

if (!empty($quoteText)):

	echo '<figure>' . "\n";
	// (plain text: masked, its line breaks kept)
	echo '<blockquote data-field="quote" data-align="'.esc($quote['align'] ?? '', 'attr').'" data-quote-size="'.esc($quote['size'] ?? 'normal', 'attr').'">'.nl2br(esc($quoteText), false).'</blockquote>' . "\n";

	if (!empty($author['text'])):
		echo '<figcaption><cite data-field="cite" data-align="'.esc($author['align'] ?? '', 'attr').'">'.esc($author['text']).'</cite></figcaption>' . "\n";
	endif;

	echo '</figure>' . "\n";

endif;
