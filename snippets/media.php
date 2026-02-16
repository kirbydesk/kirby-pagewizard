<?php

	// Image
	if ($content->mediatype()->value() === 'image'):
		snippet('image', [
			'file' => $content->image(),
			'size' => $content->mediasize()->value(),
			'alignment' => $content->mediaalignment()->value(),
		]);

	// Images
	elseif ($content->mediatype()->value() === 'slideshow'):
		snippet('images', [
			'file' => $content->images(),
			'size' => $content->mediasize()->value(),
			'alignment' => $content->mediaalignment()->value(),
		]);

	// Video
	elseif ($content->mediatype()->value() === 'video'):
		snippet('video', [
			'file' => $content->video(),
			'url' => $content->videourl()->value(),
			'size' => $content->mediasize()->value(),
			'alignment' => $content->mediaalignment()->value(),
			'source' => $content->videosource()->value(),
		]);
	endif;
