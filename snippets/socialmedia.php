<?php
$sm = $site->socialmedia()->toObject();
$links = [
    'bluesky'   => 'bluesky',
    'codepen'   => 'codepen',
    'facebook'  => 'facebook',
    'github'    => 'github',
    'instagram' => 'instagram',
    'linkedin'  => 'linkedin',
    'mastodon'  => 'mastodon',
    'threads'   => 'threads',
    'x'         => 'x',
    'xing'      => 'xing',
    'youtube'   => 'youtube',
];
$hasAny = false;
foreach ($links as $field => $_) {
    if ($sm->$field()->isNotEmpty()) { $hasAny = true; break; }
}
if (!$hasAny) return;
?>
<div class="w-full flex justify-center">
	<?php foreach ($links as $field => $icon) : ?>
		<?php if ($sm->$field()->isNotEmpty()) : ?>
			<a href="<?= $sm->$field() ?>" class="inline-block text-white" rel="nofollow noopener noreferrer" target="_blank">
				<svg class="w-5 h-5 opacity-80 fill-white"><use xlink:href="#<?= $icon ?>"></use></svg>
			</a>
		<?php endif ?>
	<?php endforeach ?>
</div>
