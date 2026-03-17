<?php

	$radiusParams = [
		'radius'            => $content->mediaradius()->value(),
		'radiusTopLeft'     => $content->radiustopleft()->value(),
		'radiusTopRight'    => $content->radiustopright()->value(),
		'radiusBottomLeft'  => $content->radiusbottomleft()->value(),
		'radiusBottomRight' => $content->radiusbottomright()->value(),
	];

	// Image
	if ($content->mediatype()->value() === 'image'):
		snippet('image', array_merge([
			'file'      => $content->image(),
			'size'      => $content->mediasize()->value(),
			'alignment' => $content->mediaalignment()->value(),
		], $radiusParams, isset($sizes) ? ['sizes' => $sizes] : []));

	// Images
	elseif ($content->mediatype()->value() === 'slideshow'):
		snippet('images', array_merge([
			'files'     => $content->slideshow(),
			'size'      => $content->mediasize()->value(),
			'alignment' => $content->mediaalignment()->value(),
		], $radiusParams, isset($sizes) ? ['sizes' => $sizes] : []));

	// Video
	elseif ($content->mediatype()->value() === 'video'):
		snippet('video', array_merge([
			'file'      => $content->video(),
			'url'       => $content->videourl()->value(),
			'size'      => $content->mediasize()->value(),
			'alignment' => $content->mediaalignment()->value(),
			'source'    => $content->videosource()->value(),
		], $radiusParams));
	endif;
