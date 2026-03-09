<?php
$logoDefault = json_decode(file_get_contents(__DIR__ . '/../config/navigation.json'), true) ?? [];
$logoPatch   = kirby()->root('site') . '/patches/config/navigation.json';
$logoCfg     = file_exists($logoPatch) ? array_merge($logoDefault, json_decode(file_get_contents($logoPatch), true) ?? []) : $logoDefault;

$site     = kirby()->site();
$homePage = $site->homePage();
$alt      = $homePage ? $homePage->title()->value() : $site->title()->value();
$href     = $homePage ? $homePage->url() : $site->url();
$base     = kirby()->urls()->assets() . '/';

if ($mobile ?? false):
	$src    = $base . ($logoCfg['mobile-logo-src'] ?? '');
	$width  = $logoCfg['mobile-logo-src-width'] ?? '';
	$height = $logoCfg['mobile-logo-src-height'] ?? '';
else:
	$src    = $base . ($logoCfg['desktop-logo-src'] ?? '');
	$width  = $logoCfg['desktop-logo-src-width'] ?? '';
	$height = $logoCfg['desktop-logo-src-height'] ?? '';
endif;

$logoSrc  = $mobile ?? false ? ($logoCfg['mobile-logo-src'] ?? '') : ($logoCfg['desktop-logo-src'] ?? '');
$logoFile = kirby()->root('assets') . '/' . $logoSrc;
$hasLogo  = !empty($src) && file_exists($logoFile);
?>
<?php if ($mobile ?? false): ?>
<a href="<?=$href?>" aria-label="<?=$alt?>" tabindex="1"><?php if ($hasLogo): ?><img src="<?=$src?>" alt="Logo" width="<?=$width?>" height="<?=$height?>"/><?php else: ?><em>Logo</em><?php endif; ?></a>
<?php else: ?>
<a href="<?=$href?>" aria-label="<?=$alt?>" class="logo" tabindex="1"><?php if ($hasLogo): ?><img src="<?=$src?>" alt="Logo" width="<?=$width?>" height="<?=$height?>"/><?php else: ?><em>Logo</em><?php endif; ?></a>
<?php endif;
