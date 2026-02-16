<?php

$file = $file?->toFile();

if ($file):
	// Thumb options
	$thumbOptions = ['width' => 1280, 'quality' => 90, 'format' => 'webp'];
	$crop = $file->imageCrop()->toBool();
	$ratio = $file->imageRatio()->value();

	// Srcset (Feature 2: responsive file sizes)
	$srcset = $file->srcset([480, 720, 960, 1280]);
	$sizes = match($size) {
		'small'  => 'min(480px, 100vw)',
		'medium' => 'min(720px, 100vw)',
		'large'  => 'min(960px, 100vw)',
		default  => '100vw',
	};

	// Image type: decorative (false) vs informative (true)
	$isInformative = $file->imageType()->toBool();

	// Title (for both decorative and informative)
	$title = $file->imageTitle()->isNotEmpty() ? esc($file->imageTitle()->value()) : '';

	// Accessibility attributes (only for informative images)
	$alt = '';
	$describedby = '';
	$describedbyId = '';

	if ($isInformative) {
		$alt = $file->imageDescription()->isNotEmpty() ? esc($file->imageDescription()->value()) : '';
		$describedby = $file->ariaDescribedby()->isNotEmpty() ? esc($file->ariaDescribedby()->value()) : '';
		$describedbyId = $describedby ? 'desc-' . $file->id() : '';
	}

	// Focus point
	$focus = $file->focus()->isNotEmpty() ? $file->focus()->value() : '50% 50%';

	// Zoom
	$zoom = $file->imageZoom()->toBool();

	// Output
	echo '<div data-field="image" data-size="'.$size.'" data-align="'.$alignment.'">';
	echo '<figure';
	e($crop, ' data-crop="cover"');
	e(!empty($ratio), ' data-ratio="'.$ratio.'"');
	e($zoom, ' data-zoom');
	echo '>';
	echo '<div>';
	echo '<img';
	echo ' src="'.$file->thumb($thumbOptions)->url().'"';
	echo ' srcset="'.$srcset.'"';
	echo ' sizes="'.$sizes.'"';
	echo ' alt="'.$alt.'"';
	e(!empty($title), ' title="'.$title.'"');
	e(!empty($describedbyId), ' aria-describedby="'.$describedbyId.'"');
	e(!$isInformative, ' role="presentation"');
	e($zoom, ' data-full="'.$file->url().'"');
	e($crop, ' style="object-position:'.$focus.'"');
	echo ' loading="lazy">';
	e($zoom, '<span class="zoom-icon" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>');
	echo '</div>';
	e(!empty($describedby), '<p id="'.$describedbyId.'" hidden>'.$describedby.'</p>');
	e($file->imageCaption()->isNotEmpty(), '<figcaption data-field="caption">'.esc($file->imageCaption()->value()).'</figcaption>');
	echo '</figure>';
	echo '</div>';

	// Load lightbox module once per page (only when zoom is used)
	if ($zoom):
		static $lightboxLoaded = false;
		if (!$lightboxLoaded):
			echo '<script src="'.$kirby->urls()->index().'/assets/js/lightbox.min.js" defer></script>';
			$lightboxLoaded = true;
		endif;
	endif;
endif;
