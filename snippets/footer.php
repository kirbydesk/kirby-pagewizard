<footer>
	<div>

		<?php if ($site->address()->toObject()->addressposition()->value() === 'left') snippet('address') ?>

		<div data-type="items">
			<?php foreach ($site->footer()->toBlocks() as $footer) : ?>
				<div class="flex-1">
					<div class="<?= $site->address()->toObject()->addressposition()->value() === 'left' ? 'md:w-fit md:ml-auto' : '' ?>">
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
				</div>
			<?php endforeach ?>
		</div>
		<?php if ($site->address()->toObject()->addressposition()->value() === 'right') snippet('address') ?>
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
	: __DIR__ . '/../assets/sprites/symbols.txt';
echo '<svg xmlns="http://www.w3.org/2000/svg" width="0" height="0" style="display:none">' . "\n";
echo file_get_contents($navSprite) . "\n";
echo '</svg>' . "\n";
?>
</body>
</html>