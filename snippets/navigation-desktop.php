<header class="desktop hidden mx-auto w-full md:block z-50 shadow-sm"<?= $sticky ? ' id="sticky"' : '' ?> role="banner">
	<div class="flex max-w-7xl mx-auto" id="navigation"><?php

		/* Logo */ ?>
		<?php snippet('logo', ['type' => 'desktop', 'tabindex' => 1]) ?>

		<nav class="flex-1 pl-8 lg:pl-6 xl:pl-8">
			<div class="flex justify-end md:space-x-5 lg:space-x-6 xl:space-x-8"><?php

				/* Show Homepage link */
				if ($class !== null) : $hp = $site->homePage(); ?><div class="navitem<?= $class ? ' ' . $class : '' ?>"><a class="item" href="<?= $hp ? $hp->url() : $site->url() ?>" tabindex="1"><?= $hp ? $hp->title()->value() : $site->title()->value() ?></a></div><?php endif;

				$tabindex  = 2;
				$itemIndex = 1;

				foreach ($items as $item) :

				$children = $item->children()->listed();
				$flip     = $flyoutFlipFrom > 0 && $itemIndex >= $flyoutFlipFrom ? ' flip' : '';
				$itemIndex++;

				/* Navigation items */ ?>
				<div class="navitem<?= $flip ?>">
					<?php if ($children->isNotEmpty()) : ?>
						<div class="item" tabindex="<?=$tabindex?>" role="button" aria-haspopup="true" aria-expanded="false">
							<?= $item->metanavigationtitle()->or($item->title()); ?>
							<?php if ($flyoutIcon) : ?><span>
								<svg class="hidden w-4 h-4 fill-current lg:inline-block">
									<use xlink:href="#<?= htmlspecialchars($flyoutIcon) ?>"></use>
								</svg>
							</span><?php endif; ?>
							<div class="flyout">
								<a href="<?= $item->url() ?>" tabindex="<?=$tabindex?>"><?= $item->title() ?></a>
									<?php foreach ($children as $child) : ?>
									<a href="<?= $child->url() ?>" class="border-t" tabindex="<?=$tabindex?>"><?= $child->title() ?></a>
									<?php endforeach ?>
							</div>
						</div>
					<?php else : ?>
						<a class="item" href="<?= $item->url() ?>" tabindex="<?=$tabindex?>"><?= $item->navigationtitle()->or($item->title()); ?></a>
					<?php endif; $tabindex++; ?>
				</div><?php

				endforeach;

				snippet('language', ['mobile' => false, 'tabindex' => $tabindex]); ?>
			</div>
		</nav>
	</div>
</header>
