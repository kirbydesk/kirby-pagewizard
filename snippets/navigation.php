<?php
/*------------------------------------------------------------------------------------------------
    Navigation
------------------------------------------------------------------------------------------------*/

$items = $pages->listed();

if ($items->isNotEmpty()) : ?>
	<header class="desktop hidden mx-auto w-full md:block z-50 shadow-sm" id="sticky" role="banner">
		<div class="flex max-w-7xl mx-auto md:px-4 lg:px-6 xl:px-8" id="navigation"><?php

			/* Logo */ ?>
			<a href="<?=$site->homePage()->url() ?>" aria-label="<?=$site->homePage()->title()->value() ?>" class="logo" tabindex="1"><img src="<?=$kirby->urls()->assets()?>/svg/logo.svg" alt="Logo Besucherbergwerk Velsen" height="70" width="70"/></a>

			<nav class="flex-1 pl-8 lg:pl-6 xl:pl-8">
				<div class="flex justify-end md:space-x-5 lg:space-x-6 xl:space-x-8"><?php

					/* Homepage */ ?>
					<div class="navitem<?php /* hidden lg:block*/ ?>">
						<a class="item" href="<?=$site->homePage()->url() ?>" tabindex="2"><?=$site->homePage()->title()->value() ?></a>
					</div>
					<?php
						$tabindex = 3;

						foreach ($items as $item) :

						$children = $item->children()->listed();

						/* Navigation items */ ?>
						<div class="navitem">
							<?php if ($children->isNotEmpty()) : ?>
								<div class="item" tabindex="<?=$tabindex?>" role="button" aria-haspopup="true" aria-expanded="false">
									<?= $item->navigationtitle()->or($item->title()); ?>
									<span>
										<svg class="hidden w-4 h-4 fill-current lg:inline-block">
											<use xlink:href="#angle-right"></use>
										</svg>
									</span>
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
						</div>
					<?php endforeach; ?>

					<div class="navitem">
						<a class="item highlight" href="https://fareharbor.com/embeds/book/erlebnisbergwerkvelsen/" target="_blank" rel="noopener noreferrer nofollow" tabindex="<?=$tabindex?>">Tickets <span><svg class="hidden -mt-1 ml-1 w-3 h-3 fill-current lg:inline-block"><use xlink:href="#external"></use></svg></span></a>
					</div>

					<?php /* Language level */ ?>
					<div class="navitem languagelevel">
						<div class="item" tabindex="<?=$tabindex?>" role="menu" aria-haspopup="true" aria-expanded="false">
							<svg class="accessibility" width="1" height="1" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 16.5185V8L6.83333 9.48148V18L1 16.5185Z" stroke="var(--header-desktop-textcolor)"/><path d="M14.8333 16.5185V8L8.99992 9.48148V18L14.8333 16.5185Z" stroke="var(--header-desktop-textcolor)"/><circle cx="8" cy="4" r="3.5" stroke="var(--header-desktop-textcolor)"/></svg>
							<div class="flyout languagelevel">
								<a href="#" id="original" role="menuitem" tabindex="<?=$tabindex?>"><?php e(!isset($_COOKIE['languagelevel']) || $_COOKIE['languagelevel'] !== 'simple', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" /></svg><span class="active">', '<span>') ?>Originalsprache</span></a>
								<a href="#" id="simple" class="border-t" role="menuitem" tabindex="<?=$tabindex?>"><?php e(isset($_COOKIE['languagelevel']) && $_COOKIE['languagelevel'] === 'simple', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" /></svg><span class="active">', '<span>') ?>Einfache Sprache</span></a>
							</div>
						</div>
					</div><?php

					/* Language */ ?>
					<div class="navitem language md:-ml-6 lg:-ml-8 xl:-ml-10">
						<div class="item md:ml-3 lg:ml-4 xl:ml-5" tabindex="<?=$tabindex?>" role="menu" aria-haspopup="true" aria-expanded="false">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="1" height="1" class="globe fill-current"><path d="M256 480c16.7 0 40.4-14.4 61.9-57.3c9.9-19.8 18.2-43.7 24.1-70.7H170c5.9 27 14.2 50.9 24.1 70.7C215.6 465.6 239.3 480 256 480zM164.3 320H347.7c2.8-20.2 4.3-41.7 4.3-64s-1.5-43.8-4.3-64H164.3c-2.8 20.2-4.3 41.7-4.3 64s1.5 43.8 4.3 64zM170 160H342c-5.9-27-14.2-50.9-24.1-70.7C296.4 46.4 272.7 32 256 32s-40.4 14.4-61.9 57.3C184.2 109.1 175.9 133 170 160zm210 32c2.6 20.5 4 41.9 4 64s-1.4 43.5-4 64h90.8c6-20.3 9.3-41.8 9.3-64s-3.2-43.7-9.3-64H380zm78.5-32c-25.9-54.5-73.1-96.9-130.9-116.3c21 28.3 37.6 68.8 47.2 116.3h83.8zm-321.1 0c9.6-47.6 26.2-88 47.2-116.3C126.7 63.1 79.4 105.5 53.6 160h83.7zm-96 32c-6 20.3-9.3 41.8-9.3 64s3.2 43.7 9.3 64H132c-2.6-20.5-4-41.9-4-64s1.4-43.5 4-64H41.3zM327.5 468.3c57.8-19.5 105-61.8 130.9-116.3H374.7c-9.6 47.6-26.2 88-47.2 116.3zm-143 0c-21-28.3-37.5-68.8-47.2-116.3H53.6c25.9 54.5 73.1 96.9 130.9 116.3zM256 512A256 256 0 1 1 256 0a256 256 0 1 1 0 512z" /></svg>
							<div class="flyout">
								<?php foreach ($kirby->languages() as $language) : ?>
								<a href="<?= $page->url($language->code()) ?>" class="border-t" role="menuitem" tabindex="<?=$tabindex?>"><?php e($kirby->language()->code() == $language, '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" /></svg><span class="active">', '<span>') ?><?= html($language->name()) ?></span></a>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</nav>
		</div>
  </header>
  <header class="mobile md:hidden">
		<div class="flex items-center justify-between w-full pl-2 pr-[14px] h-[50px]"><?php

			/* Logo */ ?>
			<a href="<?= $site->homePage()->url() ?>" aria-label="<?=$site->homePage()->title()->value() ?>" tabindex="1"><img src="<?=$kirby->urls()->assets()?>/svg/logo_mobil.svg" alt="Logo Besucherbergwerk Velsen" height="40" width="233" /></a><?php

			/* Burger */ ?>
			<div class="flex justify-end burger" tabindex="2" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Navigation öffnen"><span></span></div>
    </div>
    <nav>
    	<ul class="l1">
				<?php
					$tabindex = 3;

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
				<li class="bg-[#00C0FF]">
					<a href="https://fareharbor.com/embeds/book/erlebnisbergwerkvelsen/" target="_blank" rel="noopener noreferrer nofollow" tabindex="<?=$tabindex?>" class="block py-3 pl-4 pr-5 border-t">Tickets</a>
				</li>
			</ul>

			<div class="language flex border-t">
				<form class="flex items-center w-1/2 px-4 my-3">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="26" height="26" class="globe"><path d="M256 480c16.7 0 40.4-14.4 61.9-57.3c9.9-19.8 18.2-43.7 24.1-70.7H170c5.9 27 14.2 50.9 24.1 70.7C215.6 465.6 239.3 480 256 480zM164.3 320H347.7c2.8-20.2 4.3-41.7 4.3-64s-1.5-43.8-4.3-64H164.3c-2.8 20.2-4.3 41.7-4.3 64s1.5 43.8 4.3 64zM170 160H342c-5.9-27-14.2-50.9-24.1-70.7C296.4 46.4 272.7 32 256 32s-40.4 14.4-61.9 57.3C184.2 109.1 175.9 133 170 160zm210 32c2.6 20.5 4 41.9 4 64s-1.4 43.5-4 64h90.8c6-20.3 9.3-41.8 9.3-64s-3.2-43.7-9.3-64H380zm78.5-32c-25.9-54.5-73.1-96.9-130.9-116.3c21 28.3 37.6 68.8 47.2 116.3h83.8zm-321.1 0c9.6-47.6 26.2-88 47.2-116.3C126.7 63.1 79.4 105.5 53.6 160h83.7zm-96 32c-6 20.3-9.3 41.8-9.3 64s3.2 43.7 9.3 64H132c-2.6-20.5-4-41.9-4-64s1.4-43.5 4-64H41.3zM327.5 468.3c57.8-19.5 105-61.8 130.9-116.3H374.7c-9.6 47.6-26.2 88-47.2 116.3zm-143 0c-21-28.3-37.5-68.8-47.2-116.3H53.6c25.9 54.5 73.1 96.9 130.9 116.3zM256 512A256 256 0 1 1 256 0a256 256 0 1 1 0 512z" /></svg>
					<fieldset class="w-full">
						<div class="relative">
							<select id="language" name="language" class="block w-full h-6 pl-2 pr-6 text-sm bg-white border rounded-md appearance-none text-darkgrey border-darkgrey focus:outline-none">
								<?php foreach ($kirby->languages() as $language) : ?>
								<option <?php e($kirby->language() == $language, 'selected="selected" '); ?>value="<?= $page->url($language->code()) ?>"><?= html($language->name()) ?></option>
								<?php endforeach ?>
							</select>
							<div class="absolute top-[7px] right-[6px] items-center pointer-events-none">
								<svg viewBox="0 0 448 512" width="12" height="12" class="fill-darkgrey"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z" /></svg>
							</div>
						</div>
					</fieldset>
				</form>
				<form class="flex items-center w-1/2 px-4 my-3">
					<svg width="25" height="25" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg" class="accessibility"><path d="M1 16.5185V8L6.83333 9.48148V18L1 16.5185Z"/><path d="M14.8333 16.5185V8L8.99992 9.48148V18L14.8333 16.5185Z"/><circle cx="8" cy="4" r="3.5"/></svg>
					<fieldset class="w-full">
						<div class="relative">
							<select id="languagelevel" name="languagelevel" class="block w-full h-6 pl-2 pr-6 text-sm bg-white border rounded-md appearance-none text-darkgrey border-darkgrey focus:outline-none">
								<option value="original" <?php e(!isset($_COOKIE['languagelevel']) || $_COOKIE['languagelevel'] !== 'simple', 'selected'); ?>>Standardsprache</option>
								<option value="simple" <?php e(isset($_COOKIE['languagelevel']) && $_COOKIE['languagelevel'] === 'simple', 'selected'); ?>>Einfache Sprache</option>
							</select>
							<div class="absolute top-[7px] right-[6px] items-center pointer-events-none">
								<svg viewBox="0 0 448 512" width="12" height="12" class="fill-current"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z" /></svg>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</nav>
  </header>
<?php endif;