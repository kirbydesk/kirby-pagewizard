<?php
	$initialOpenItem = null;
	$expandableIndex = 0;

	foreach ($items as $item) {
		if ($item->children()->listed()->isNotEmpty()) {
			if ($item->isOpen() && $initialOpenItem === null) {
				$initialOpenItem = $expandableIndex;
			}
			$expandableIndex++;
		}
	}

?><header class="mobile md:hidden" x-data="mobileNav(<?= $initialOpenItem === null ? 'null' : $initialOpenItem ?>)" x-init="init()">
	<div class="flex items-center justify-between w-full h-(--nav-mobile-height)"><?php

		/* Logo */ ?>
		<?php snippet('logo', ['type' => 'mobile', 'tabindex' => 1]) ?><?php

		/* Burger */ ?>
		<div
			class="flex justify-end burger"
			tabindex="2"
			role="button"
			aria-haspopup="true"
			:aria-expanded="String(navOpen)"
			aria-label="Navigation öffnen"
			:class="{ 'open': navOpen }"
			@click="toggleNav()"
			@keydown.enter.prevent="toggleNav()"
			@keydown.space.prevent="toggleNav()"
			@keydown.escape.prevent="closeNav()"
		><span></span></div>
	</div>
	<nav x-show="navOpen" x-collapse.duration.300ms x-cloak>
		<ul class="l1">
			<?php
				$tabindex = 3;
				$expandableIndex = 0;

				/* Homepage Link */
				if ($config['home-mobile'] ?? true) : ?><li><?php $hp = $site->homePage() ?><a href="<?= $hp ? $hp->url() : $site->url() ?>" tabindex="<?=$tabindex?>" class="block py-3 pl-4 pr-5 border-t"><?= $hp ? $hp->title()->html() : $site->title()->html() ?></a></li><?php $tabindex++; endif;

				foreach ($items as $item) :
				$children = $item->children()->listed();

				// Item Active ?
				$liClasses = [];
				if ($item->isOpen()) $liClasses[] = 'active';
				$liClassAttr = empty($liClasses) ? '' : ' class="' . implode(' ', $liClasses) . '"';

				// Subnav available -> Show +/- Icons
				if ($children->isNotEmpty()) : ?>
				<li<?= $liClassAttr ?> :class="{ 'open': isItemOpen(<?= $expandableIndex ?>) }" :aria-expanded="String(isItemOpen(<?= $expandableIndex ?>))">
					<div
						class="item flex items-center justify-between py-3 pl-4 pr-5 border-t hover:cursor-pointer"
						tabindex="<?=$tabindex?>"
						role="button"
						aria-haspopup="true"
						:aria-expanded="String(isItemOpen(<?= $expandableIndex ?>))"
						@click.prevent.stop="toggleItem(<?= $expandableIndex ?>)"
						@keydown.enter.prevent="toggleItem(<?= $expandableIndex ?>)"
						@keydown.space.prevent="toggleItem(<?= $expandableIndex ?>)"
					>
						<span class="flex justify-start"><?= $item->metanavigationtitle()->html()->or($item->title()->html()); ?></span>
						<span class="flex justify-end hover:cursor-pointer">
							<svg class="plus"><use xlink:href="#fa-plus"></use></svg>
							<svg class="minus"><use xlink:href="#fa-minus"></use></svg>
						</span>
					</div>
				<?php else : ?>
				<li<?= $liClassAttr ?>>
					<a href="<?= $item->url() ?>" tabindex="<?=$tabindex?>" class="block py-3 pl-4 pr-5 border-t"><?= $item->navigationtitle()->html()->or($item->title()->html()) ?></a>
				<?php endif;

				// Subnav available -> Show lists
				if ($children->isNotEmpty()) : ?>
				<ul class="l2" x-show="isItemOpen(<?= $expandableIndex ?>)" x-collapse.duration.300ms x-cloak>
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
				<?php $expandableIndex++;endif;

				$tabindex++; ?>
			</li>
			<?php endforeach ?>
		</ul>
		<?php snippet('language', ['mobile' => true]); ?>
	</nav>
</header>
