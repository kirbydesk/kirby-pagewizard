<?php

$images = $files?->toFiles();

if ($images && $images->count() > 0):

	// Use first image for container settings
	$first = $images->first();
	$crop = $first->imageCrop()->toBool();
	$ratio = $first->imageRatio()->value();

	// Unique ID for this slideshow instance
	$slideshowId = 'pw-slideshow-' . uniqid();

	// Container
	echo '<div data-field="slideshow" data-size="'.$size.'" data-align="'.$alignment.'">';
	echo '<figure';
	e($crop, ' data-crop="cover"');
	e(!empty($ratio), ' data-ratio="'.$ratio.'"');
	echo '>';
	echo '<div>';

	// Swiper
	echo '<div class="swiper" id="'.$slideshowId.'">';
	echo '<div class="swiper-wrapper">';

	$isFirst = true;
	foreach ($images as $image):
		// Thumb
		$thumbOptions = ['width' => 1280, 'quality' => 90, 'format' => 'webp'];
		$srcset = $image->srcset([480, 720, 960, 1280]);
		$sizes = match($size) {
			'small'  => 'min(480px, 100vw)',
			'medium' => 'min(720px, 100vw)',
			'large'  => 'min(960px, 100vw)',
			default  => '100vw',
		};

		// Image type: decorative (false) vs informative (true)
		$isInformative = $image->imageType()->toBool();

		// Title
		$title = $image->imageTitle()->isNotEmpty() ? esc($image->imageTitle()->value()) : '';

		// Accessibility
		$alt = '';
		if ($isInformative) {
			$alt = $image->imageDescription()->isNotEmpty() ? esc($image->imageDescription()->value()) : '';
		}

		// Focus point
		$focus = $image->focus()->isNotEmpty() ? $image->focus()->value() : '50% 50%';

		// Slide
		echo '<div class="swiper-slide">';
		echo '<img';
		echo ' src="'.$image->thumb($thumbOptions)->url().'"';
		echo ' srcset="'.$srcset.'"';
		echo ' sizes="'.$sizes.'"';
		echo ' alt="'.$alt.'"';
		e(!empty($title), ' title="'.$title.'"');
		e(!$isInformative, ' role="presentation"');
		e($crop, ' style="object-position:'.$focus.'"');
		e(!$isFirst, ' loading="lazy"');
		echo '>';
		echo '</div>';
		$isFirst = false;
	endforeach;

	echo '</div>'; // swiper-wrapper
	echo '<div class="swiper-pagination"></div>';
	echo '</div>'; // swiper

	echo '</div>'; // figure > div
	echo '</figure>';
	echo '</div>'; // data-field="slideshow"

	// Load Swiper JS module once per page
	static $swiperLoaded = false;
	if (!$swiperLoaded):
		echo '<script src="'.$kirby->urls()->index().'/assets/js/swiper.min.js"></script>';
		$swiperLoaded = true;
	endif;

	// Init Swiper
	echo '<script>';
	echo 'new Swiper("#'.$slideshowId.'",{';
	echo 'spaceBetween:0,';
	echo 'centeredSlides:true,';
	echo 'autoplay:{delay:4000,disableOnInteraction:false},';
	echo 'pagination:{el:"#'.$slideshowId.' .swiper-pagination",clickable:true}';
	echo '});';
	echo '</script>';

endif;
