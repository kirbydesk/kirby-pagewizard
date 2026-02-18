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
		'xsmall' => '25vw',
		'small'  => '33vw',
		'medium' => '50vw',
		'large'  => '75vw',
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
	if ($zoom):
		$captionText = $file->imageCaption()->isNotEmpty() ? esc($file->imageCaption()->value()) : '';
		$lightboxId = 'img-' . uniqid();
		echo '<a href="'.$file->url().'" class="glightbox" data-gallery="'.$lightboxId.'" aria-label="'.t('pw.lightbox.open').'"';
		e(!empty($captionText), ' data-description="'.$captionText.'"');
		echo '>';
	endif;
	echo '<img';
	echo ' src="'.$file->thumb($thumbOptions)->url().'"';
	echo ' srcset="'.$srcset.'"';
	echo ' sizes="'.$sizes.'"';
	echo ' alt="'.$alt.'"';
	e(!empty($title), ' title="'.$title.'"');
	e(!empty($describedbyId), ' aria-describedby="'.$describedbyId.'"');
	e(!$isInformative, ' role="presentation"');
	e($crop, ' style="object-position:'.$focus.'"');
	echo ' loading="lazy">';
	if ($zoom):
		echo '<span class="zoom-icon" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>';
		echo '</a>';
	endif;
	echo '</div>';
	e(!empty($describedby), '<p id="'.$describedbyId.'" hidden>'.$describedby.'</p>');
	e($file->imageCaption()->isNotEmpty(), '<figcaption data-field="caption">'.esc($file->imageCaption()->value()).'</figcaption>');
	echo '</figure>';
	echo '</div>';

	// Load GLightbox once per page (only when zoom is used)
	if ($zoom):
		static $lightboxLoaded = false;
		if (!$lightboxLoaded):
			echo '<link rel="stylesheet" href="'.$kirby->urls()->index().'/assets/css/glightbox.min.css">';
			echo '<script src="'.$kirby->urls()->index().'/assets/js/glightbox.min.js" defer></script>';
			echo '<script defer>document.addEventListener("DOMContentLoaded",function(){GLightbox({selector:".glightbox",touchNavigation:false,loop:false,draggable:false,closeOnOutsideClick:true,zoomable:false,openEffect:"fade",closeEffect:"fade"})});</script>';
			$lightboxLoaded = true;
		endif;
	endif;
endif;
