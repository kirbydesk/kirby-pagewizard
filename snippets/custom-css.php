<?php // Custom CSS block styles

?><style>
	section[data-block-id="<?=$blockid?>"] {
		background-color:<?=$backgroundcolor?>;
	}
	section[data-block-id="<?=$blockid?>"] [data-field="heading"],
	section[data-block-id="<?=$blockid?>"] [data-field="tagline"],
	section[data-block-id="<?=$blockid?>"] [data-field="textarea"],
	section[data-block-id="<?=$blockid?>"] [data-field="writer"],
	section[data-block-id="<?=$blockid?>"] [data-field="markdown"],
	section[data-block-id="<?=$blockid?>"] [data-field="icon"]{
		color: <?=$textcolor?>;
	}
	section[data-block-id="<?=$blockid?>"] [data-field="icon"] svg {
		fill: <?=$textcolor?>;
	}
	section[data-block-id="<?=$blockid?>"] [data-opacity="dimmed"]{
		color: color-mix(in srgb, <?=$textcolor?> 80%, transparent);
	}
	section[data-block-id="<?=$blockid?>"] [data-field="slideshow"] .swiper-pagination-bullet,
	section[data-block-id="<?=$blockid?>"] [data-field="slideshow"] .swiper-pagination-bullet-active {
			background: <?=$textcolor?>;
	}
</style>