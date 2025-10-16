<?php return [

	/* -------------- Hooks --------------*/
	'route:after' => function () {
		$contentDir = kirby()->root('content');
			// Create required content files if they do not exist
			$files = [
				'site.txt',
				'home/home.txt',
				'error/error.txt'
			];

			if (kirby()->multilang()):
				// If project is multilingual, create files with default language suffix
				$defaultLang = kirby()->defaultLanguage()->code();
				$files = [
					"site.$defaultLang.txt",
					"home/home.$defaultLang.txt",
					"error/error.$defaultLang.txt"
				];
			endif;

			foreach ($files as $file):
				$path = $contentDir . '/' . $file;
				$dir = dirname($path);
				// Create directory if it does not exist
				if (!is_dir($dir)):
					mkdir($dir, 0777, true);
				endif;
				// Create empty file if it does not exist
				if (!file_exists($path)):
					file_put_contents($path, '');
				endif;
			endforeach;
		}
];