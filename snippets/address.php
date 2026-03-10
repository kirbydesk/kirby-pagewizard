<?php $address = $site->address()->toObject() ?>
<div class="text-white text-sm shrink-0 w-max">
	<?php if ($address->addressname()->isNotEmpty()) : ?>
		<strong class="block mb-1"><?= $address->addressname() ?></strong>
	<?php endif ?>
	<?php if ($address->address()->isNotEmpty()) : ?>
		<div class="mb-3 opacity-80"><?= $address->address() ?></div>
	<?php endif ?>
	<?php if ($address->addresscountry()->isNotEmpty()) : ?>
		<div class="mb-3"><?= $address->addresscountry() ?></div>
	<?php endif ?>
	<?php if ($address->addressphone()->isNotEmpty()) : ?>
		<a href="tel:<?= cleanTel($address->addressphone()) ?>" class="inline-block mb-1 no-underline text-white">
			<svg class="fill-white inline mb-[2px] mr-2 h-3 w-3"><use xlink:href="#phone"></use></svg>
			<span class="border-b border-white border-dotted opacity-80"><?= $address->addressphone() ?></span>
		</a><br>
	<?php endif ?>
	<?php if ($address->addressemail()->isNotEmpty()) : ?>
		<a href="mailto:<?= $address->addressemail() ?>" class="inline-block no-underline text-white">
			<svg class="fill-white inline mb-[2px] mr-2 h-3 w-3"><use xlink:href="#mailto"></use></svg>
			<span class="border-b border-white border-dotted opacity-80"><?= $address->addressemail() ?></span>
		</a>
	<?php endif ?>
</div>
