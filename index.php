<?php Kirby::plugin(

name: 'chrfickinger/kirby-pages',
license: [
	'name' => 'Proprietary license',
	'status' => [
		'value' => 'valid',
		'theme' => 'positive',
		'label' => 'Valid',
		'icon'  => 'check',
		'link'  => 'https://christianfickinger.de',
	]
],
extends: [

	/* -------------- Extensions --------------*/
	'hooks' 				=> require_once 'src/extensions/hooks.php',
  'translations' 	=> require_once 'src/extensions/translations.php',
  'areas' 				=> require_once 'src/extensions/areas.php',



	/* -------------- Blueprints --------------*/
	'blueprints' => [

		/* -------------- Pages --------------*/
		'site' => __DIR__ . '/blueprints/site.yml',
		'pages/article' => __DIR__ . '/blueprints/pages/article.yml',
		'pages/category' => __DIR__ . '/blueprints/pages/category.yml',
		'pages/error' => __DIR__ . '/blueprints/pages/error.yml',
		'pages/home' => __DIR__ . '/blueprints/pages/home.yml',

		/* -------------- Tabs --------------*/
		'tabs/content' => __DIR__ . '/blueprints/tabs/content.yml',
		'tabs/home' => __DIR__ . '/blueprints/tabs/home.yml',
		'tabs/project' => __DIR__ . '/blueprints/tabs/project.yml',
		'tabs/properties' => __DIR__ . '/blueprints/tabs/properties.yml',
		'tabs/settings' => __DIR__ . '/blueprints/tabs/settings.yml',
		'tabs/site' => __DIR__ . '/blueprints/tabs/site.yml',
		'tabs/structure' => __DIR__ . '/blueprints/tabs/structure.yml',

		/* -------------- Blocks --------------*/
		'blocks/footer' => __DIR__ . '/blueprints/blocks/footer/index.yml',
		'blocks/footerItem' => __DIR__ . '/blueprints/blocks/footer/item.yml',
		'blocks/socialmedia' => __DIR__ . '/blueprints/blocks/socialmedia/index.yml',
		'blocks/socialmediaItem' => __DIR__ . '/blueprints/blocks/socialmedia/item.yml',

		/* -------------- Fields --------------*/
		'kirbypages/headlines/accessibility' => __DIR__ . '/blueprints/panel/headlines/accessibility.yml',
	],

	/* -------------- Snippets --------------*/
	'snippets' => [
		'footer' => __DIR__ . '/snippets/footer.php',
		'header' => __DIR__ . '/snippets/header.php',
		'navigation' => __DIR__ . '/snippets/navigation.php'
	],

	/* -------------- Templates --------------*/
	'templates' => [
		'article' => __DIR__ . '/templates/article.php',
		'category' => __DIR__ . '/templates/category.php',
		'error' => __DIR__ . '/templates/error.php',
		'home' => __DIR__ . '/templates/home.php'
	]

]);