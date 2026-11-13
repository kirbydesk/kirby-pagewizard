<?php

/**
 * Favicon from the Project Wizard. The uploaded PNG (square, at least
 * 512 × 512) and the optional SVG live in content/.projectwizard/favicon –
 * they travel with the content, like the uploaded fonts. The sizes browsers
 * and phones ask for are made at runtime with GD and written into
 * media/pagewizard/favicon/<hash>/ on the first request; the hash covers the
 * files and the background, so a replaced favicon gets new URLs.
 */
class pwFavicon
{
	/** The files the head links to, with their size (null: no resizing) */
	public const FILES = [
		'favicon.ico'          => 32,
		'favicon.svg'          => null,
		'apple-touch-icon.png' => 180,
		'icon-192.png'         => 192,
		'icon-512.png'         => 512,
		'site.webmanifest'     => null,
	];

	/** Smallest side of the uploaded PNG */
	public const MIN_SIZE = 512;

	public static function dir(): string
	{
		return pwConfig::projectDir() . '/favicon';
	}

	public static function png(): ?string
	{
		$file = self::dir() . '/favicon.png';
		return is_file($file) ? $file : null;
	}

	public static function svg(): ?string
	{
		$file = self::dir() . '/favicon.svg';
		return is_file($file) ? $file : null;
	}

	/** Settings next to the files – for now the background of the app icons */
	public static function settings(): array
	{
		$file = self::dir() . '/favicon.json';
		$data = is_file($file) ? json_decode((string) file_get_contents($file), true) : null;
		return is_array($data) ? $data : [];
	}

	/** Background of the app icons (iPhone fills transparency black) – #rrggbb, white by default */
	public static function background(): string
	{
		$color = self::settings()['background'] ?? '';
		return is_string($color) && preg_match('/^#[0-9a-f]{6}$/i', $color) ? strtolower($color) : '#ffffff';
	}

	public static function exists(): bool
	{
		return self::png() !== null;
	}

	public static function hash(): string
	{
		$parts = [self::background()];
		foreach ([self::png(), self::svg()] as $file) {
			if ($file) $parts[] = basename($file) . ':' . filesize($file) . ':' . filemtime($file);
		}
		return substr(md5(implode('|', $parts)), 0, 12);
	}

	public static function url(string $name): string
	{
		return kirby()->url('media') . '/pagewizard/favicon/' . self::hash() . '/' . $name;
	}

	/** The <link> tags for the page head – empty without an uploaded favicon */
	public static function head(): string
	{
		if (!self::exists()) return '';
		$html = '<link rel="icon" href="' . self::url('favicon.ico') . '" sizes="32x32">';
		if (self::svg()) {
			$html .= '<link rel="icon" type="image/svg+xml" href="' . self::url('favicon.svg') . '">';
		}
		$html .= '<link rel="apple-touch-icon" href="' . self::url('apple-touch-icon.png') . '">';
		$html .= '<link rel="manifest" href="' . self::url('site.webmanifest') . '">';
		return $html;
	}

	/**
	 * Route media/pagewizard/favicon/<hash>/<file>: made once and written into
	 * the media folder, after that the web server delivers it. An outdated
	 * hash (e.g. from a cached page) gets the current file without storing it.
	 */
	public static function response(string $hash, string $name): \Kirby\Http\Response|false
	{
		// the SVG on its own (uploaded before the PNG): shown in the Panel already
		if (!array_key_exists($name, self::FILES) || (!self::exists() && $name !== 'favicon.svg')) return false;
		$made = self::make($name);
		if ($made === null) return false;
		[$body, $type] = $made;

		if ($hash === self::hash()) {
			$dir = kirby()->root('media') . '/pagewizard/favicon/' . $hash;
			// older versions are of no use anymore
			foreach (glob(kirby()->root('media') . '/pagewizard/favicon/*', GLOB_ONLYDIR) ?: [] as $old) {
				if ($old !== $dir) \Kirby\Filesystem\Dir::remove($old);
			}
			if (!is_dir($dir)) mkdir($dir, 0777, true);
			file_put_contents($dir . '/' . $name, $body);
			return new \Kirby\Http\Response($body, $type, 200, ['Cache-Control' => 'public, max-age=31536000, immutable']);
		}
		return new \Kirby\Http\Response($body, $type, 200, ['Cache-Control' => 'no-cache']);
	}

	/** Route /favicon.ico – for browsers and crawlers that don't read the head */
	public static function rootResponse(): \Kirby\Http\Response|false
	{
		if (!self::exists()) return false;
		$made = self::make('favicon.ico');
		return $made ? new \Kirby\Http\Response($made[0], $made[1], 200, ['Cache-Control' => 'public, max-age=86400']) : false;
	}

	/** [body, mime type] of one file – null if it can't be made (no SVG uploaded, …) */
	public static function make(string $name): ?array
	{
		if ($name === 'favicon.svg') {
			$svg = self::svg();
			return $svg ? [(string) file_get_contents($svg), 'image/svg+xml'] : null;
		}
		if (!self::png()) return null;
		switch ($name) {
			case 'site.webmanifest':
				return [self::manifest(), 'application/manifest+json'];
			case 'favicon.ico':
				return [self::ico([16, 32, 48]), 'image/x-icon'];
			default:
				$size = self::FILES[$name] ?? null;
				if (!$size) return null;
				// app icons get the background, the browser icons stay transparent
				return [self::resized($size, self::background()), 'image/png'];
		}
	}

	/** PNG in the given size, optionally on a background colour. Without GD: the uploaded PNG */
	public static function resized(int $size, ?string $background = null): string
	{
		$file = self::png();
		if (!function_exists('imagecreatefrompng') || !($source = @imagecreatefrompng($file))) {
			return (string) file_get_contents($file);
		}
		$image = imagecreatetruecolor($size, $size);
		if ($background) {
			[$r, $g, $b] = sscanf($background, '#%02x%02x%02x');
			imagefill($image, 0, 0, imagecolorallocate($image, $r, $g, $b));
			imagealphablending($image, true);
		} else {
			imagealphablending($image, false);
			imagefill($image, 0, 0, imagecolorallocatealpha($image, 0, 0, 0, 127));
		}
		imagesavealpha($image, true);
		imagecopyresampled($image, $source, 0, 0, 0, 0, $size, $size, imagesx($source), imagesy($source));
		ob_start();
		imagepng($image, null, 9);
		return (string) ob_get_clean();
	}

	/** ICO with PNG images inside (every browser since IE Vista reads them) */
	public static function ico(array $sizes): string
	{
		$images = array_map(fn ($size) => self::resized($size), $sizes);
		$header = pack('vvv', 0, 1, count($images));
		$offset = 6 + 16 * count($images);
		$entries = '';
		foreach ($images as $i => $data) {
			$size = $sizes[$i] >= 256 ? 0 : $sizes[$i];
			$entries .= pack('CCCCvvVV', $size, $size, 0, 0, 1, 32, strlen($data), $offset);
			$offset += strlen($data);
		}
		return $header . $entries . implode('', $images);
	}

	public static function manifest(): string
	{
		$title = (string) site()->title()->value();
		return json_encode([
			'name'             => $title,
			'short_name'       => $title,
			'icons'            => [
				['src' => self::url('icon-192.png'), 'sizes' => '192x192', 'type' => 'image/png'],
				['src' => self::url('icon-512.png'), 'sizes' => '512x512', 'type' => 'image/png'],
			],
			'theme_color'      => self::background(),
			'background_color' => self::background(),
			'display'          => 'browser',
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	}
}
