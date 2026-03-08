<?php
if ($kirby->languages()->count() < 2) return;

$globe = '<svg class="fill-current globe" aria-hidden="true"><use xlink:href="#globe"></use></svg>';

if ($mobile ?? false): ?>
<div class="language flex border-t">
	<form class="flex items-center w-1/2 px-4 my-3">
		<?=$globe?>
		<fieldset class="w-full">
			<div class="relative">
				<select id="language" name="language" class="block w-full h-6 pl-2 pr-6 text-sm bg-white border rounded-md appearance-none text-darkgrey border-darkgrey focus:outline-none">
					<?php foreach ($kirby->languages() as $language) : ?>
					<option <?php e($kirby->language() == $language, 'selected="selected" '); ?>value="<?= $page->url($language->code()) ?>"><?= html($language->name()) ?></option>
					<?php endforeach ?>
				</select>
				<div class="absolute top-[7px] right-1.5 items-center pointer-events-none">
					<svg width="12" height="12" class="fill-darkgrey" aria-hidden="true"><use xlink:href="#chevron-down"></use></svg>
				</div>
			</div>
		</fieldset>
	</form>
</div>
<?php else: ?>
<div class="navitem language md:-ml-6 lg:-ml-8 xl:-ml-10">
	<div class="item md:ml-3 lg:ml-4 xl:ml-5" tabindex="<?=$tabindex?>" role="menu" aria-haspopup="true" aria-expanded="false">
		<?=$globe?>
		<div class="flyout">
			<?php foreach ($kirby->languages() as $language) : ?>
			<a href="<?= $page->url($language->code()) ?>" class="border-t" role="menuitem" tabindex="<?=$tabindex?>"><?php e($kirby->language()->code() == $language, '<svg class="fill-current" aria-hidden="true"><use xlink:href="#check"></use></svg><span class="active">', '<span>') ?><?= html($language->name()) ?></span></a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif;
