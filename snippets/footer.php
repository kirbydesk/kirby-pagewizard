<?php
	$footerCfg = pwConfig::footerConfig();
	$renderLogo = function () use ($footerCfg) {
		if (empty($footerCfg['footer-logo-src'])) return;
		$h = $footerCfg['footer-logo-display-height'] ?? '';
		echo '<div data-type="logo"'.($h ? ' style="height:'.$h.'"' : '').'>'.$footerCfg['footer-logo-src'].'</div>';
	};
?>
<footer>
	<div>

		<?php if ($site->address()->toObject()->addressposition()->value() === 'left') : ?>
			<?php $renderLogo(); ?>
			<?php snippet('address') ?>
		<?php endif; ?>

		<div data-type="items">
			<?php foreach ($site->footer()->toBlocks() as $footer) : ?>
				<div class="flex-1">
					
						<div data-type="category"><?= $footer->name() ?></div><?php

							foreach ($footer->blocks()->toBlocks() as $item) :
							?><div data-type="item">
								<?php snippet('link', [
									'linkType'        => $item->linktype()->isTrue(),
									'linkInternal'    => $item->content()->get('link-internal')->value(),
									'linkExternal'    => $item->content()->get('link-external')->value(),
									'linkText'        => $item->linktext()->value(),
									'linkTarget'      => $item->linktarget()->isTrue(),
									'linkRel'         => $item->linkrel()->value(),
									'ariaLabel'       => $item->arialabel()->value(),
									'ariaDescribedby' => $item->ariadescribedby()->value(),
								]) ?>
							</div>
						<?php endforeach ?>
					
				</div>
			<?php endforeach ?>
		</div>
		<?php if ($site->address()->toObject()->addressposition()->value() === 'right') : ?>
			<?php $renderLogo(); ?>
			<?php snippet('address') ?>
		<?php endif; ?>
	</div><?php

	// Social media
	if ($site->socialmedia()->toObject()->socialmediaposition()->value() === 'footerbottom') :
		echo '<div data-type="socialmedia">';
		snippet('socialmedia', ['size' => 'large']);
		echo '</div>';
	endif;

	// Copyright
	e($site->copyright()->isNotEmpty(), '<div data-type="copyright"><p>© ' . date('Y') . ' ' . $site->copyright()->value() . '</p></div>');

?></footer><?php


// SVG sprite — project patch overrides plugin default
$navSprite = file_exists($kirby->roots()->index() . '/site/patches/sprites/symbols.txt')
	? $kirby->roots()->index() . '/site/patches/sprites/symbols.txt'
	: kirby()->plugin('kirbydesk/kirby-pagewizard')->root() . '/assets/sprites/symbols.txt';
echo '<svg xmlns="http://www.w3.org/2000/svg" width="0" height="0" style="display:none">' . "\n";
echo file_get_contents($navSprite) . "\n";
echo '</svg>' . "\n";
?>
</body>
</html>