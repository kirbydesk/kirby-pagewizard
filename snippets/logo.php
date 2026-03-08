<?php
$logoDefault = json_decode(file_get_contents(__DIR__ . '/../config/navigation.json'), true) ?? [];
$logoPatch   = kirby()->root('site') . '/patches/config/navigation.json';
$logoCfg     = file_exists($logoPatch) ? array_merge($logoDefault, json_decode(file_get_contents($logoPatch), true) ?? []) : $logoDefault;

$alt  = $site->homePage()->title()->value();
$href = $site->homePage()->url();
$base = $kirby->urls()->assets() . '/';

if ($mobile ?? false):
	$src    = $base . $logoCfg['mobile-logo-src'];
	$width  = $logoCfg['mobile-logo-src-width'];
	$height = $logoCfg['mobile-logo-src-height'];
else:
	$src    = $base . $logoCfg['desktop-logo-src'];
	$width  = $logoCfg['desktop-logo-src-width'];
	$height = $logoCfg['desktop-logo-src-height'];
endif;
?>
<?php if ($mobile ?? false): ?>
<a href="<?=$href?>" aria-label="<?=$alt?>" tabindex="1"><img src="<?=$src?>" alt="Logo" width="<?=$width?>" height="<?=$height?>"/></a>
<?php else: ?>
<a href="<?=$href?>" aria-label="<?=$alt?>" class="logo" tabindex="1"><img src="<?=$src?>" alt="Logo" width="<?=$width?>" height="<?=$height?>"/></a>
<?php endif;
