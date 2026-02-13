<?php

/* -------------- Helpers --------------*/
require_once __DIR__ . '/src/helpers/blocks/config.php';
require_once __DIR__ . '/src/helpers/blocks/grid.php';
require_once __DIR__ . '/src/helpers/blocks/spacing.php';
require_once __DIR__ . '/src/helpers/blocks/theme.php';

Kirby::plugin('kirbydesk/kirby-pagewizard', [

	/* -------------- Extensions --------------*/
	'api'						=> require_once 'src/extensions/api.php',
  'areas' 				=> require_once 'src/extensions/areas.php',
	'blueprints'		=> require_once 'src/extensions/blueprints.php',
	'fields'				=> require_once 'src/extensions/fields.php',
	'hooks'					=> require_once 'src/extensions/hooks.php',
	'snippets'			=> require_once 'src/extensions/snippets.php',
	'templates'			=> require_once 'src/extensions/templates.php',
  'translations' 	=> require_once 'src/extensions/translations.php',
]);