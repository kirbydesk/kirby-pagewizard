<header class="mobile md:hidden">
	<div class="flex items-center justify-between w-full pl-2 pr-3.5 h-(--nav-mobile-height)"><?php

		/* Logo */ ?>
		<?php snippet('logo', ['mobile' => true]); ?><?php

		/* Burger */ ?>
		<div class="flex justify-end burger" tabindex="2" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Navigation öffnen"><span></span></div>
	</div>
	<nav>
		<ul class="l1">
			<?php
				$tabindex = 3;

				/* Homepage */
				if ($config['home-mobile'] ?? true) : ?>
				<li>
					<?php $hp = $site->homePage() ?>
				<a href="<?= $hp ? $hp->url() : $site->url() ?>" tabindex="<?=$tabindex?>" class="block py-3 pl-4 pr-5 border-t"><?= $hp ? $hp->title()->html() : $site->title()->html() ?></a>
				</li>
				<?php $tabindex++; endif;

				foreach ($items as $item) :
				$children = $item->children()->listed();

				// Item Active ?
				e($item->isOpen(), '<li class="active">', '<li>');

				// Subnav available -> Show +/- Icons
				if ($children->isNotEmpty()) : ?>
					<div class="item flex items-center justify-between py-3 pl-4 pr-5 border-t hover:cursor-pointer" tabindex="<?=$tabindex?>" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="flex justify-start"><?= $item->navigationtitle()->html()->or($item->title()->html()); ?></span>
						<span class="flex justify-end hover:cursor-pointer">
							<svg class="plus"><use xlink:href="#fa-plus"></use></svg>
							<svg class="minus"><use xlink:href="#fa-minus"></use></svg>
						</span>
					</div>
				<?php else : ?>
					<a href="<?= $item->url() ?>" tabindex="<?=$tabindex?>" class="block py-3 pl-4 pr-5 border-t"><?= $item->navigationtitle()->html()->or($item->title()->html()) ?></a>
				<?php endif;

				// Subnav available -> Show lists
				if ($children->isNotEmpty()) : ?>
				<ul class="l2">
					<li class="<?php e($item->isOpen() && $page->uri() == $item->uri(), ' active'); ?>">
						<a href="<?= $item->url(); ?>" tabindex="<?=$tabindex?>" class="flex items-center p-3">
							<div class="ml-2 text-sm"><?= $item->title()->html() ?></div>
						</a>
					</li>
					<?php foreach ($children as $child) : ?>
					<li class="border-t<?php e($child->isOpen(), ' active'); ?>">
						<a href="<?= $child->url(); ?>" tabindex="<?=$tabindex?>" class="flex items-center p-3<?php e($item->isOpen(), ' active'); ?>">
							<div class="ml-2 text-sm"><?= $child->navigationtitle()->html()->or($child->title()->html()) ?></div>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php endif;

				$tabindex++; ?>
			</li>
			<?php endforeach ?>
		</ul>

		<?php snippet('language', ['mobile' => true]); ?>
	</nav>
</header>
