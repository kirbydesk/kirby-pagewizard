<?php
$sm = $site->socialmedia()->toObject();
$links = [
    'bluesky'   => ['icon' => 'bluesky',   'label' => 'Bluesky'],
    'codepen'   => ['icon' => 'codepen',   'label' => 'CodePen'],
    'facebook'  => ['icon' => 'facebook',  'label' => 'Facebook'],
    'github'    => ['icon' => 'github',    'label' => 'GitHub'],
    'instagram' => ['icon' => 'instagram', 'label' => 'Instagram'],
    'linkedin'  => ['icon' => 'linkedin',  'label' => 'LinkedIn'],
    'mastodon'  => ['icon' => 'mastodon',  'label' => 'Mastodon'],
    'threads'   => ['icon' => 'threads',   'label' => 'Threads'],
    'x'         => ['icon' => 'x',         'label' => 'X (Twitter)'],
    'xing'      => ['icon' => 'xing',      'label' => 'Xing'],
    'youtube'   => ['icon' => 'youtube',   'label' => 'YouTube'],
];
$hasAny = false;
foreach ($links as $field => $_) {
    if ($sm->$field()->isNotEmpty()) { $hasAny = true; break; }
}
if (!$hasAny) return;

foreach ($links as $field => $link):
	if ($sm->$field()->isNotEmpty()) : ?>
		<a href="<?= $sm->$field() ?>" class="inline-block" aria-label="<?= $link['label'] ?>" rel="nofollow noopener noreferrer" target="_blank">
			<svg class="<?= match($size ?? '') { 'small' => 'w-5 h-5', 'large' => 'w-8 h-8' } ?>" aria-hidden="true"><use xlink:href="#<?= $link['icon'] ?>"></use></svg>
		</a><?php
	endif;
endforeach;