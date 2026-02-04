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
			file_exists($kirby->roots()->assets()."/svg/favicon.js") && print '<link rel="icon" type="image/svg+xml" href="'.$kirby->urls()->assets().'/svg/favicon.svg">';
			file_exists($kirby->urls()->index()."/favicon.png") && print '<link rel="icon" type="image/png" href="'.$kirby->urls()->index().'/favicon.png"	>';

		?>
		<title><?=$page->title()->value()?></title>
	</head>
<body class="<?php e($kirby->user(), 'debug-screens'); ?>">
<?php snippet('navigation'); ?>