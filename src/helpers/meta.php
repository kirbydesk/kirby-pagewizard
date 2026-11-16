<?php

/**
 * The page head's meta data: title, description, the image for sharing,
 * robots, canonical, the languages and Open Graph. The website's rules
 * (Project Wizard → Project › Search engines) live in
 * content/.projectwizard/seo.json, a page can differ under "Properties"
 * (metapagetitle, metadescription, metaimage, seohidden).
 */
class pwMeta
{
	/** The rules with their start values */
	public const DEFAULTS = [
		'site'        => '',        // the website's name (empty: the site's title)
		'order'       => 'page',    // page – website / website – page / page only (none)
		'separator'   => '–',
		'home'        => 'site',    // the home page: the website's name only, or as all pages (same)
		'description' => 'text',    // without its own: the start of the first text, or none
	];

	/** Size of the image for sharing (Open Graph) */
	public const IMAGE_WIDTH  = 1200;
	public const IMAGE_HEIGHT = 630;
	/** Google shortens the description after about this many characters */
	public const DESCRIPTION_LENGTH = 155;

	public static function dir(): string
	{
		return pwConfig::projectDir() . '/seo';
	}

	public static function settings(): array
	{
		$file = pwConfig::projectDir() . '/seo.json';
		$data = is_file($file) ? json_decode((string) file_get_contents($file), true) : null;
		$settings = array_merge(self::DEFAULTS, is_array($data) ? array_intersect_key($data, self::DEFAULTS) : []);
		if (!in_array($settings['order'], ['page', 'site', 'none'], true)) $settings['order'] = 'page';
		if (!in_array($settings['separator'], ['–', '|', '·', '/'], true)) $settings['separator'] = '–';
		if (!in_array($settings['home'], ['site', 'same'], true)) $settings['home'] = 'site';
		if (!in_array($settings['description'], ['text', 'none'], true)) $settings['description'] = 'text';
		return $settings;
	}

	public static function siteName(): string
	{
		$name = trim((string) self::settings()['site']);
		return $name !== '' ? $name : (string) site()->title()->value();
	}

	/* -------------- Title --------------*/

	/** The title of the browser tab, in Google and for sharing */
	public static function title(\Kirby\Cms\Page $page): string
	{
		$own = trim((string) $page->metapagetitle()->value());
		return $own !== '' ? $own : self::autoTitle($page);
	}

	/** The title by the website's rules (the placeholder of the page's SEO title) */
	public static function autoTitle(\Kirby\Cms\Page $page): string
	{
		$settings = self::settings();
		$site = self::siteName();
		if ($page->isHomePage() && $settings['home'] === 'site') return $site;
		$title = (string) $page->title()->value();
		if ($settings['order'] === 'none' || $site === '') return $title;
		$separator = ' ' . $settings['separator'] . ' ';
		return $settings['order'] === 'site' ? $site . $separator . $title : $title . $separator . $site;
	}

	/* -------------- Description --------------*/

	public static function description(\Kirby\Cms\Page $page): string
	{
		$own = trim((string) $page->metadescription()->value());
		return $own !== '' ? $own : self::autoDescription($page);
	}

	/** Without its own: the start of the page's first text (as set in the Project Wizard) */
	public static function autoDescription(\Kirby\Cms\Page $page): string
	{
		if (self::settings()['description'] !== 'text') return '';
		$text = self::firstText($page);
		if (mb_strlen($text) <= self::DESCRIPTION_LENGTH) return $text;
		$cut = mb_substr($text, 0, self::DESCRIPTION_LENGTH);
		return preg_replace('/\s+\S*$/u', '', $cut) . ' …';
	}

	/** The first text of the page's blocks (an editor, else a heading) – plain text */
	public static function firstText(\Kirby\Cms\Page $page): string
	{
		$blocks = json_decode((string) $page->blocks()->value(), true);
		if (!is_array($blocks)) return '';
		$heading = '';
		$found = '';
		$walk = function (array $list) use (&$walk, &$heading, &$found) {
			foreach ($list as $block) {
				if ($found !== '' || !is_array($block) || ($block['isHidden'] ?? false)) continue;
				$content = $block['content'] ?? [];
				if (!is_array($content)) continue;
				// the editor: as JSON with its mode and the text of each mode
				$editor = isset($content['editor']) && is_string($content['editor']) ? json_decode($content['editor'], true) : null;
				if (is_array($editor)) {
					$mode = $editor['mode'] ?? 'textarea';
					$found = self::plain((string) ($editor[$mode] ?? ''));
				}
				if ($heading === '' && isset($content['heading']) && is_string($content['heading'])) {
					$h = json_decode($content['heading'], true);
					$heading = self::plain((string) (is_array($h) ? ($h['text'] ?? '') : $content['heading']));
				}
				// blocks inside blocks (columns, cards …)
				foreach ($content as $value) {
					if ($found !== '') break;
					$inner = is_string($value) && str_starts_with(ltrim($value), '[{') ? json_decode($value, true) : null;
					if (is_array($inner)) $walk($inner);
				}
			}
		};
		$walk($blocks);
		return $found !== '' ? $found : $heading;
	}

	private static function plain(string $text): string
	{
		$text = \Kirby\Toolkit\Str::unhtml(kirbytext($text));
		return trim(preg_replace('/\s+/u', ' ', html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
	}

	/* -------------- Image for sharing --------------*/

	/** The website's image (Project Wizard), if there is one */
	public static function defaultImage(): ?string
	{
		foreach (glob(self::dir() . '/share.*') ?: [] as $file) {
			if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp'], true)) return $file;
		}
		return null;
	}

	public static function defaultImageUrl(): ?string
	{
		$file = self::defaultImage();
		if (!$file) return null;
		$hash = substr(md5(basename($file) . ':' . filesize($file) . ':' . filemtime($file)), 0, 12);
		return kirby()->url('media') . '/pagewizard/share/' . $hash . '/share.jpg';
	}

	/** The page's own image, else the website's – cropped to 1200 × 630 */
	public static function imageUrl(\Kirby\Cms\Page $page): ?string
	{
		$file = $page->metaimage()->toFile();
		if ($file && $file->type() === 'image') {
			return $file->thumb(['width' => self::IMAGE_WIDTH, 'height' => self::IMAGE_HEIGHT, 'crop' => true, 'format' => 'jpg'])->url();
		}
		return self::defaultImageUrl();
	}

	/**
	 * Route media/pagewizard/share/<hash>/share.jpg: the website's image
	 * cropped to 1200 × 630, written into the media folder on the first
	 * request (afterwards the web server delivers it)
	 */
	public static function imageResponse(string $hash): \Kirby\Http\Response|false
	{
		$file = self::defaultImage();
		if (!$file) return false;
		$body = self::cropped($file);
		$current = substr(md5(basename($file) . ':' . filesize($file) . ':' . filemtime($file)), 0, 12);
		if ($hash === $current) {
			$dir = kirby()->root('media') . '/pagewizard/share/' . $hash;
			foreach (glob(kirby()->root('media') . '/pagewizard/share/*', GLOB_ONLYDIR) ?: [] as $old) {
				if ($old !== $dir) \Kirby\Filesystem\Dir::remove($old);
			}
			if (!is_dir($dir)) mkdir($dir, 0777, true);
			file_put_contents($dir . '/share.jpg', $body);
			return new \Kirby\Http\Response($body, 'image/jpeg', 200, ['Cache-Control' => 'public, max-age=31536000, immutable']);
		}
		return new \Kirby\Http\Response($body, 'image/jpeg', 200, ['Cache-Control' => 'no-cache']);
	}

	/** The image filling 1200 × 630, centred (without GD: as it is) */
	private static function cropped(string $file): string
	{
		$binary = (string) file_get_contents($file);
		if (!function_exists('imagecreatefromstring') || !($source = @imagecreatefromstring($binary))) return $binary;
		[$w, $h] = [imagesx($source), imagesy($source)];
		$scale = max(self::IMAGE_WIDTH / $w, self::IMAGE_HEIGHT / $h);
		$cw = (int) round(self::IMAGE_WIDTH / $scale);
		$ch = (int) round(self::IMAGE_HEIGHT / $scale);
		$image = imagecreatetruecolor(self::IMAGE_WIDTH, self::IMAGE_HEIGHT);
		imagefill($image, 0, 0, imagecolorallocate($image, 255, 255, 255));
		imagecopyresampled($image, $source, 0, 0, (int) (($w - $cw) / 2), (int) (($h - $ch) / 2), self::IMAGE_WIDTH, self::IMAGE_HEIGHT, $cw, $ch);
		ob_start();
		imagejpeg($image, null, 85);
		return (string) ob_get_clean();
	}

	/* -------------- Search engines --------------*/

	/**
	 * Shown in search engines: not when the page says so, never on a
	 * password protected host (staging) – the old field "Robots" is not
	 * used (its start value was "noindex, nofollow" on almost every page)
	 */
	public static function indexed(\Kirby\Cms\Page $page): bool
	{
		if (option('kirbydesk.protect') || option('kirbydesk.pagewizard.protected')) return false;
		return !$page->seohidden()->toBool();
	}

	/* -------------- The head --------------*/

	public static function head(\Kirby\Cms\Page $page): string
	{
		$kirby = kirby();
		$e = fn ($value) => htmlspecialchars((string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$title = self::title($page);
		$description = self::description($page);
		$image = self::imageUrl($page);
		$language = $kirby->language();

		$lines = ['<title>' . $e($title) . '</title>'];
		if ($description !== '') $lines[] = '<meta name="description" content="' . $e($description) . '">';
		if (!self::indexed($page)) $lines[] = '<meta name="robots" content="noindex">';
		$lines[] = '<link rel="canonical" href="' . $e($page->url()) . '">';

		// the page in every language (and the default one for all others)
		if ($kirby->multilang()) {
			foreach ($kirby->languages() as $lang) {
				if (!$page->translation($lang->code())?->exists() && !$lang->isDefault()) continue;
				$lines[] = '<link rel="alternate" hreflang="' . $e($lang->code()) . '" href="' . $e($page->url($lang->code())) . '">';
			}
			$lines[] = '<link rel="alternate" hreflang="x-default" href="' . $e($page->url($kirby->defaultLanguage()->code())) . '">';
		}

		// sharing (WhatsApp, LinkedIn, Slack …)
		$lines[] = '<meta property="og:type" content="website">';
		$lines[] = '<meta property="og:site_name" content="' . $e(self::siteName()) . '">';
		$lines[] = '<meta property="og:title" content="' . $e($title) . '">';
		if ($description !== '') $lines[] = '<meta property="og:description" content="' . $e($description) . '">';
		$lines[] = '<meta property="og:url" content="' . $e($page->url()) . '">';
		if ($language) $lines[] = '<meta property="og:locale" content="' . $e(preg_replace('/\..*$/', '', str_replace('-', '_', (string) ($language->locale(LC_ALL) ?: $language->code())))) . '">';
		if ($image) {
			$lines[] = '<meta property="og:image" content="' . $e($image) . '">';
			$lines[] = '<meta property="og:image:width" content="' . self::IMAGE_WIDTH . '">';
			$lines[] = '<meta property="og:image:height" content="' . self::IMAGE_HEIGHT . '">';
		}
		$lines[] = '<meta name="twitter:card" content="' . ($image ? 'summary_large_image' : 'summary') . '">';
		return implode("\n\t\t", $lines);
	}
}
