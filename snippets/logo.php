<?php

// Config
$logoCfg = pwConfig::navConfig();

// Link
$site     = kirby()->site();
$homePage = $site->homePage();
$href     = $homePage ? $homePage->url() : $site->url();
$alt      = $homePage ? $homePage->title()->value() : $site->title()->value();

// Logo (inline SVG)
$logoSrc = $logoCfg[$type . '-logo-src'] ?? '';
$hasLogo = !empty($logoSrc) && str_contains($logoSrc, '<svg');

if ($hasLogo) : ?>
<a href="<?= $href ?>" aria-label="<?= $alt ?>" class="logo logo-<?= $type ?>"<?= isset($tabindex) ? ' tabindex="' . $tabindex . '"' : '' ?>>
	<?= $logoSrc ?>
</a>
<?php endif;
