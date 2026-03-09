<!DOCTYPE html>
<html lang="<?= ($kirby->language() ? $kirby->language()->code() : 'de') ?>">
	<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
		<meta name="theme-color" content="var(--darkred)">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta http-equiv="X-UA-Compatible" content="ie=edge"><?php

			/* CSS */
			file_exists($kirby->roots()->assets()."/css/site.min.css") && print '<link rel="stylesheet" href="'.$kirby->urls()->assets().'/css/site.min.css?'.filemtime($kirby->roots()->assets().'/css/site.min.css').'" />';

			/* JS */
			file_exists($kirby->roots()->assets()."/js/site.min.js") && print '<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script><script src="'.$kirby->urls()->assets().'/js/site.min.js?'.filemtime($kirby->roots()->assets().'/js/site.min.js').'" defer></script>';

			/* Favicon */
			file_exists($kirby->roots()->index()."/favicon.ico") && print '<link rel="icon" href="'.$kirby->urls()->index().'/favicon.ico" sizes="32x32">';
			file_exists($kirby->roots()->assets()."/img/favicon.svg") && print '<link rel="icon" type="image/svg+xml" href="'.$kirby->urls()->assets().'/img/favicon.svg">';
			file_exists($kirby->roots()->assets()."/img/apple-touch-icon.png") && print '<link rel="apple-touch-icon" href="'.$kirby->urls()->assets().'/img/apple-touch-icon.png">';

		?>
		<title><?=$page->metapagetitle()->or($page->title() . ' | ' . $site->title())?></title>
	</head>
<body class="<?php e($kirby->user(), 'debug-screens'); ?>">
<?php
	// Config settings
	$default = json_decode(file_get_contents(__DIR__ . '/../config/navigation.json'), true) ?? [];
	$patch   = kirby()->root('site') . '/patches/config/navigation.json';
	$config  = file_exists($patch) ? array_merge($default, json_decode(file_get_contents($patch), true) ?? []) : $default;
	$sticky	 = (bool)($config['sticky'] ?? true);

	// Define class for homepage item in desktop navigation
	$desktop = (bool)($config['home-desktop'] ?? true);
	$tablet  = (bool)($config['home-tablet'] ?? true);

	if ($desktop && $tablet) $class = '';
	elseif ($desktop && !$tablet) $class = 'hidden lg:block';
	elseif (!$desktop && $tablet) $class = 'lg:hidden';
	else $class = null;

	// Items
	$items = $pages->listed();
	if ($items->isNotEmpty()) :
		snippet('navigation-desktop', [
			'items'          => $items,
			'class'          => $class,
			'sticky'         => $sticky,
			'flyoutIcon'     => $config['desktop-flyout-icon'] ?? '',
			'flyoutFlipFrom' => (int)($config['desktop-flyout-flip-from'] ?? 0),
		]);
		snippet('navigation-mobile', [
			'items' => $items,
			'config' => $config
		]);
	endif;

?><div id="scroll-sentinel" aria-hidden="true"></div><?php