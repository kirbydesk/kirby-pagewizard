<?php

// Radius
$radiusValue = $radius ?? '';
$radiusStyle = '';
if ($radiusValue === 'round') {
	$radiusStyle = 'border-radius:9999px;overflow:hidden;';
} elseif ($radiusValue === 'custom') {
	$isTrue = fn($v) => $v === true || $v === 'true' || $v === 1;
	$tl = $isTrue($radiusTopLeft     ?? false) ? 'var(--media-radius-top-left)'     : '0';
	$tr = $isTrue($radiusTopRight    ?? false) ? 'var(--media-radius-top-right)'    : '0';
	$br = $isTrue($radiusBottomRight ?? false) ? 'var(--media-radius-bottom-right)' : '0';
	$bl = $isTrue($radiusBottomLeft  ?? false) ? 'var(--media-radius-bottom-left)'  : '0';
	$radiusStyle = "border-radius:{$tl} {$tr} {$br} {$bl};overflow:hidden;";
}

// Internal Video
if ($source === 'internal'):

	$file = $file?->toFile();

	if ($file):
		// Title
		$title = $file->videoTitle()->isNotEmpty() ? esc($file->videoTitle()->value()) : '';

		// Ratio
		$ratio = $file->videoRatio()->value();

		// Player settings
		$autoplay = $file->videoAutoplay()->toBool();
		$muted = $file->videoMuted()->toBool();
		$loop = $file->videoLoop()->toBool();
		$controls = $file->videoControls()->toBool();
		$preload = $file->videoPreload()->value() ?: 'auto';

		// Poster
		$poster = $file->videoPoster()->toFile();
		$posterUrl = '';
		if ($poster) {
			$posterUrl = $poster->thumb(['width' => 1280, 'quality' => 70, 'format' => 'webp'])->url();
		}

		// Accessibility
		$ariaLabel = $file->ariaLabel()->isNotEmpty() ? esc($file->ariaLabel()->value()) : '';
		$describedby = $file->ariaDescribedby()->isNotEmpty() ? esc($file->ariaDescribedby()->value()) : '';
		$describedbyId = $describedby ? 'desc-' . $file->id() : '';

		// Tracks
		$captionFile = $file->videoCaption()->toFile();
		$subtitleFile = $file->videoSubtitle()->toFile();
		$audiodescFile = $file->videoAudiodescription()->toFile();
		$chaptersFile = $file->videoChapters()->toFile();

		// Transcript (writer field, contains HTML)
		$transcript = $file->videoTranscript()->isNotEmpty() ? $file->videoTranscript()->value() : '';

		// Language
		$lang = kirby()->language()?->code() ?? 'en';

		// Ratio (round overrides file ratio)
		if ($radiusValue === 'round') $ratio = '1/1';

		// Output
		echo '<div data-field="video" data-size="'.$size.'" data-align="'.$alignment.'">';
		echo '<figure';
		e(!empty($ratio), ' data-ratio="'.$ratio.'"');
		e(!empty($radiusStyle), ' style="'.$radiusStyle.'"');
		echo '>';
		echo '<div>';
		echo '<video';
		e(!empty($title), ' title="'.$title.'"');
		e(!empty($ariaLabel), ' aria-label="'.$ariaLabel.'"');
		e(!empty($describedbyId), ' aria-describedby="'.$describedbyId.'"');
		e(!empty($posterUrl), ' poster="'.$posterUrl.'"');
		e($autoplay, ' autoplay muted');
		e(!$autoplay && $muted, ' muted');
		e($controls, ' controls');
		e($loop, ' loop');
		echo ' preload="'.$preload.'"';
		echo ' playsinline>';
		echo '<source src="'.$file->url().'" type="'.$file->mime().'">';
		e($captionFile, '<track kind="captions" src="'.$captionFile?->url().'" srclang="'.$lang.'" label="Captions">');
		e($subtitleFile, '<track kind="subtitles" src="'.$subtitleFile?->url().'" srclang="'.$lang.'" label="Subtitles">');
		e($audiodescFile, '<track kind="descriptions" src="'.$audiodescFile?->url().'" srclang="'.$lang.'" label="Audio Description">');
		e($chaptersFile, '<track kind="chapters" src="'.$chaptersFile?->url().'" srclang="'.$lang.'" label="Chapters">');
		echo '</video>';
		echo '</div>';
		e(!empty($describedby), '<p id="'.$describedbyId.'" hidden>'.$describedby.'</p>');
		e(!empty($transcript), '<figcaption data-field="caption">'.$transcript.'</figcaption>');
		echo '</figure>';
		echo '</div>';
	endif;

// External Video (YouTube, Vimeo)
elseif ($source === 'external' && !empty($url)):

	$embedUrl = '';

	// YouTube
	if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube(?:-nocookie)?\.com\/embed\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
		$embedUrl = 'https://www.youtube-nocookie.com/embed/' . $matches[1];
	}
	// Vimeo
	elseif (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url, $matches)) {
		$embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
	}

	if ($embedUrl):
		$externalRatio = $radiusValue === 'round' ? '1/1' : '16/9';
		echo '<div data-field="video" data-size="'.$size.'" data-align="'.$alignment.'">';
		echo '<figure data-ratio="'.$externalRatio.'"';
		e(!empty($radiusStyle), ' style="'.$radiusStyle.'"');
		echo '>';
		echo '<div>';
		echo '<iframe';
		echo ' src="'.esc($embedUrl).'"';
		echo ' allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"';
		echo ' allowfullscreen';
		echo ' loading="lazy"';
		echo '></iframe>';
		echo '</div>';
		echo '</figure>';
		echo '</div>';
	endif;

endif;
