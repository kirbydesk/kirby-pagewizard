<footer>
	<div class="flex gap-8 p-3 mx-auto md:p-4 lg:p-6 xl:p-8 max-w-7xl">

		<?php if ($site->address()->toObject()->addressposition()->value() === 'left') snippet('address') ?>

		<div class="flex flex-1 gap-8">
			<?php foreach ($site->footer()->toBlocks() as $footer) : ?>
				<div class="flex-1">
					<div class="<?= $site->address()->toObject()->addressposition()->value() === 'left' ? 'w-fit ml-auto' : '' ?>">
						<div data-type="category"><?= $footer->name() ?></div><?php

							foreach ($footer->blocks()->toBlocks() as $item) :
							?><div class="mb-1.25">
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
//									'class' => 'inline-block no-underline text-sm leading-4.5 text-white opacity-80',

	// Social media
	snippet('socialmedia');

	// Copyright
	e($site->copyright()->isNotEmpty(), '<p class="pt-10 text-xs italic lg:text-center">© ' . date('Y') . ' ' . $site->copyright()->html() . '</p>');

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