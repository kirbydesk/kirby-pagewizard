<?php

$sharedId = $block->sharedid()->value();
if (empty($sharedId)) return;

$entry = site()->sharedblocks()->toBlocks()
	->filter(fn($b) => $b->id() === $sharedId)
	->first();

if (!$entry) return;

echo snippet('blocks/' . $entry->type(), ['block' => $entry], true);
