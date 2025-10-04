<?php snippet('sections/quiz'); ?>
<?php snippet('sections/contact'); ?>
<footer>


	<div class="p-3 mx-auto md:p-4 lg:p-6 xl:p-8 max-w-7xl">

	<div class="grid grid-cols-1 gap-4 mx-auto max-w-7xl md:gap-8 sm:grid-cols-4 lg:flex lg:gap-16 xl:gap-24"><?php

		foreach ($site->footer()->toBlocks() as $footer) : ?>
			<div class="mb-3 lg:mb-0">
				<div class="mb-1 font-bold text-white"><?= $footer->category() ?></div><?php

					foreach ($footer->blocks()->toBlocks() as $item) :
          $svg = $target = '';

					if ($item->target()->isTrue()) :
		        $svg = '&nbsp;<svg class="fill-white opacity-80 inline mb-[2px] h-3 w-3"><use xlink:href="#fa-external"></use></svg>';
						$target = ' target="_blank"';
					endif; ?>

					<div class="mb-[5px]">
							<a class="inline-block no-underline text-sm leading-[18px] text-white opacity-80" href="<?= $item->link()->toUrl() ?>" title="<?= $item->title() ?>" <?= $target ?>><?= $item->name() . $svg ?></a>
					</div><?php

					endforeach ?>
        </div>
        <?php endforeach; ?>

        <?php if ($site->address()->isNotEmpty()) : ?>
            <div class="col-span-1 text-white lg:text-right sm:col-span-4 lg:flex-grow address">

                <?php e($site->addresstitle()->isNotEmpty(), '<strong class="block mb-1 text-sm">' . $site->addresstitle() . '</strong>') ?>
                <div class="mb-4 text-sm opacity-80">
                    <?= $site->address() ?>
                </div>
                <?php e($site->addressphone()->isNotEmpty(), '<a title="' . t('site.footer.call') . '" href="tel:' . cleanTel($site->addressphone()) . '" class="inline-block mb-1 text-sm"><svg class="fill-white inline mb-[2px] mr-[8px] h-3 w-3"><use xlink:href="#fa-phone"></use></svg><span class="border-b border-white border-dotted opacity-80">' . $site->addressphone() . '</span></a><br>') ?>
                <?php e($site->addressemail()->isNotEmpty(), '<a title="' . t('site.footer.mailto') . '" href="mailto:' . $site->addressemail() . '" class="inline-block text-sm"><svg class="fill-white inline mb-[2px] mr-[8px] h-3 w-3"><use xlink:href="#fa-mailto"></use></svg><span class="border-b border-white border-dotted opacity-80">' . $site->addressemail() . '</span></a>') ?>

                <?php // Social Media

                if ($site->facebookurl()->isNotEmpty()  || $site->linkedinurl()->isNotEmpty() || $site->instagramurl()->isNotEmpty() || $site->youtubeurl()->isNotEmpty()) : ?>
                    <div class="flex gap-2 mt-4 lg:justify-end">

                        <?php // Facebook
                        if ($site->facebookurl()->isNotEmpty()) :
                            echo '<a href="' . $site->facebookurl() . '" title="' . $site->facebooktitle() . '" class="inline-block text-white" rel="nofollow, noopener, noreferrer" target="_blank">';
                            echo '<svg class="w-5 h-5 opacity-80 fill-white"><use xlink:href="#fa-facebook"></use></svg>';
                            echo '</a>';
                        endif;

                        // LinkedIn
                        if ($site->linkedinurl()->isNotEmpty()) :
                            echo '<a href="' . $site->linkedinurl() . '" title="' . $site->linkedintitle() . '" class="inline-block text-white" rel="nofollow, noopener, noreferrer" target="_blank">';
                            echo '<svg class="w-5 h-5 opacity-80 fill-white"><use xlink:href="#fa-linkedin"></use></svg>';
                            echo '</a>';
                        endif;

                        // Instagram
                        if ($site->instagramurl()->isNotEmpty()) :
                            echo '<a href="' . $site->instagramurl() . '" title="' . $site->instagramtitle() . '" class="inline-block text-white" rel="nofollow, noopener, noreferrer" target="_blank">';
                            echo '<svg class="w-5 h-5 opacity-80 fill-white"><use xlink:href="#fa-instagram"></use></svg>';
                            echo '</a>';
                        endif;

                        // YouTube
                        if ($site->youtubeurl()->isNotEmpty()) :
                            echo '<a href="' . $site->youtubeurl() . '" title="' . $site->youtubetitle() . '" class="inline-block text-white" rel="nofollow, noopener, noreferrer" target="_blank">';
                            echo '<svg class="w-5 h-5 opacity-80 fill-white"><use xlink:href="#fa-youtube"></use></svg>';
                            echo '</a>';
                        endif;?>

                    </div>

					<?php endif; ?>
				</div>
			<?php endif ?>
    </div>
		<?php // e($site->copyright()->isNotEmpty(), '<p class="pt-10 text-xs italic text-[var(--grey)] opacity-80 lg:text-center">© ' . date('Y') . ' ' . $site->copyright()->html() . '</p>') ?>
	</div>
	</footer>

<?php
// Include global SVG definitions
if (file_exists($kirby->roots()->assets() . '/svg/symbols.txt')) :
	echo '<svg xmlns="http://www.w3.org/2000/svg" width="0" height="0" style="display: none">' . "\n";
	echo file_get_contents($kirby->roots()->assets() . '/svg/symbols.txt') . "\n";
	echo '</svg>' . "\n";
endif; ?>
</body>
</html>