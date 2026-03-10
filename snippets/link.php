<?php
// Required: $linkText
// Internal link: $linkInternal (raw value: page://, file://, mailto:, tel:, #anchor)
// External link: $linkExternal + $linkType = true
// Optional: $linkTarget, $rel, $ariaLabel, $ariaDescribedby

// Allow passing a pre-resolved $url directly
if (!isset($url)) :
	$url = '';
endif;

if (empty($url)) :
if (!empty($linkType)) :
	$url = $linkExternal ?? '';
else :
	$linkValue = $linkInternal ?? '';
	try {

		if (Str::startsWith($linkValue, 'page://')) :
			$url = kirby()->site()->index()->findBy('uuid', $linkValue)?->url()
				?? (new \Kirby\Cms\Field(null, 'value', $linkValue))->toPage()?->url()
				?? '';

		elseif (Str::startsWith($linkValue, 'file://')) :
			$url = (new \Kirby\Cms\Field(null, 'value', $linkValue))->toFile()?->url() ?? '';

		elseif (Str::startsWith($linkValue, 'mailto:')) :
			$url = $linkValue;

		elseif (Str::startsWith($linkValue, 'email:')) :
			$url = 'mailto:' . Str::after($linkValue, 'email:');

		elseif (Str::startsWith($linkValue, 'tel:')) :
			$url = $linkValue;

		elseif (Str::startsWith($linkValue, 'anchor:')) :
			$url = '#' . Str::after($linkValue, 'anchor:');

		elseif (Str::startsWith($linkValue, '#')) :
			$url = $linkValue;

		else :
			$url = $linkValue;

		endif;

	} catch (Exception $e) {
		$url = '';
	}
endif;
endif; // empty($url)

if (empty($url)) return;

$svg         = $target = '';
$rel         = (!empty($linkType) && isset($linkRel) && $linkRel !== '') ? ' rel="' . esc($linkRel) . '"' : '';
$label       = isset($ariaLabel) && $ariaLabel !== '' ? ' aria-label="' . esc($ariaLabel) . '"'              : '';
$describedby = isset($ariaDescribedby) && $ariaDescribedby !== '' ? ' aria-describedby="' . esc($ariaDescribedby) . '"' : '';

if (!empty($linkType) && !empty($linkTarget)) :
	$target = ' target="_blank"';
	$svg    = '<svg aria-hidden="true" class="external"><use xlink:href="#external"></use></svg>';
endif;


?><a href="<?= $url ?>"<?= $target . $rel . $label . $describedby ?>><?= $linkText . $svg ?></a>