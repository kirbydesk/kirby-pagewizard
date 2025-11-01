<?php Kirby::plugin('kirbydesk/kirby-pagewizard', [

	/* -------------- Extensions --------------*/
  'areas' 				=> require_once 'src/extensions/areas.php',
	'blueprints'		=> require_once 'src/extensions/blueprints.php',
	'snippets'			=> require_once 'src/extensions/snippets.php',
	'templates'			=> require_once 'src/extensions/templates.php',
  'translations' 	=> require_once 'src/extensions/translations.php',
]);