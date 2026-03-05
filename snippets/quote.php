<?php

$quoteRaw  = $content->quote()->value();
$authorRaw = $content->author()->value();

$quote  = ($quoteRaw === null || $quoteRaw === '') ? [] : (json_decode($quoteRaw, true) ?? []);
$author = ($authorRaw === null || $authorRaw === '') ? [] : (json_decode($authorRaw, true) ?? []);


$quoteText = $quote['textarea'] ?? '';

if (!empty($quoteText)):

	echo '<figure>' . "\n";
	echo '<blockquote data-field="quote" data-align="'.$quote['align'].'" data-quote-size="'.($quote['size'] ?? 'normal').'">'.$quoteText.'</blockquote>' . "\n";

	if (!empty($author['text'])):
		echo '<figcaption><cite data-field="cite" data-align="'.$author['align'].'">'.$author['text'].'</cite></figcaption>' . "\n";
	endif;

	echo '</figure>' . "\n";

endif;
