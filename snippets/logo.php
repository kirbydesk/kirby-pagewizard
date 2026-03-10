<?php

// Config
$logoDefault = json_decode(file_get_contents(__DIR__ . '/../config/navigation.json'), true) ?? [];
$logoPatch   = kirby()->root('site') . '/patches/config/navigation.json';
$logoCfg     = file_exists($logoPatch)
	? array_merge($logoDefault, json_decode(file_get_contents($logoPatch), true) ?? [])
	: $logoDefault;

// Link
$site     = kirby()->site();
$homePage = $site->homePage();
$href     = $homePage ? $homePage->url() : $site->url();
$alt      = $homePage ? $homePage->title()->value() : $site->title()->value();

// Image
$src           = kirby()->urls()->assets() . '/' . ($logoCfg[$type . '-logo-src'] ?? '');
$width         = $logoCfg[$type . '-logo-src-width']          ?? '';
$height        = $logoCfg[$type . '-logo-src-height']         ?? '';
$hasLogo       = !empty($src) && file_exists(kirby()->root('assets') . '/' . ($logoCfg[$type . '-logo-src'] ?? ''));

?>
<a href="<?= $href ?>" aria-label="<?= $alt ?>" class="logo"<?= isset($tabindex) ? ' tabindex="' . $tabindex . '"' : '' ?>>
	<?php if ($hasLogo) : ?>
		<img src="<?= $src ?>" alt="Logo" width="<?= $width ?>" height="<?= $height ?>"<?= $type === 'footer' && ($h = $logoCfg['footer-logo-display-height'] ?? '') ? ' style="height:' . $h . '"' : '' ?> />
	<?php else : ?>
		<em>Logo</em>
	<?php endif ?>
</a>
