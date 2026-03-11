<?php $address = $site->address()->toObject() ?>
<div data-type="address">
	<?php snippet('logo', ['type' => 'footer']); ?>
	<div data-type="info">
		<?php // Address
		if ($address->addressname()->isNotEmpty()) : ?>
			<div data-type="name"><?= $address->addressname() ?></div>
		<?php endif;

		if ($address->address()->isNotEmpty()) : ?>
			<div><?= $address->address() ?></div>
			<?php if ($address->addresscountry()->isNotEmpty()) : ?>
				<div><?= $address->addresscountry() ?></div>
			<?php endif;
		endif;

		// Phonenumbers
		if ($address->addressphone()->isNotEmpty() || $address->addresswhatsapp()->isNotEmpty() || $address->addressemail()->isNotEmpty()):

			echo '<div data-type="phonenumbers">';

			if ($address->addressphone()->isNotEmpty()) : ?>
				<a href="tel:<?= cleanTel($address->addressphone()) ?>" class="inline-block mb-1 no-underline">
					<svg class="inline mb-0.5 mr-2 h-4 w-4"><use xlink:href="#phone"></use></svg>
					<span class="border-b border-dotted"><?= $address->addressphone() ?></span>
				</a>
			<?php endif;

			if ($address->addresswhatsapp()->isNotEmpty()) : ?>
				<a href="mailto:<?= $address->addresswhatsapp() ?>" class="inline-block no-underline">
					<svg class="inline mb-0.5 mr-2 h-4 w-4"><use xlink:href="#whatsapp"></use></svg>
					<span class="border-b border-dotted"><?= $address->addresswhatsapp() ?></span>
				</a>
			<?php endif;

			if ($address->addressemail()->isNotEmpty()) : ?>
				<a href="mailto:<?= $address->addressemail() ?>" class="inline-block no-underline">
					<svg class="inline mb-0.5 mr-2 h-4 w-4"><use xlink:href="#mailto"></use></svg>
					<span class="border-b border-dotted"><?= $address->addressemail() ?></span>
				</a>
			<?php endif;

			echo '</div>';
		endif;

		// Social media
		if ($site->socialmedia()->toObject()->socialmediaposition()->value() === 'addressblock') : ?>
			<div data-type="socialmedia" class="mt-4 flex gap-2"><?php snippet('socialmedia', ['size' => 'small']); ?></div>
		<?php endif; ?>
	</div>
</div>
