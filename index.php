<?php Kirby::plugin('kirbydesk/pages', [

	/* -------------- Extensions --------------*/
  'areas' 				=> require_once 'src/extensions/areas.php',
	'blueprints'		=> require_once 'src/extensions/blueprints.php',
	'hooks' 				=> require_once 'src/extensions/hooks.php',
	'snippets'			=> require_once 'src/extensions/snippets.php',
	'templates'			=> require_once 'src/extensions/templates.php',
  'translations' 	=> require_once 'src/extensions/translations.php',
]);