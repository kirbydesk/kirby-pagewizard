<?php

/**
 * API keys of the kirbydesk AI plugins, kept in the project's `.env`
 * (next to the `site` folder). The keys stay on the server: they are
 * neither part of the content deploy nor of git, and the panel only ever
 * sees a masked version.
 *
 * AI plugins declare their keys with a `secrets` option:
 *   'secrets' => fn () => [
 *       ['env' => 'ANTHROPIC_API_KEY', 'option' => 'anthropic.apiKey', 'label' => …, 'help' => …],
 *   ]
 * `option` is the plugin option that takes precedence (e.g. set in
 * config.php); `env` is the .env variable the panel reads and writes.
 */
class pwSecrets
{
	/** AI plugins that may declare keys (same list as the AI view button). */
	public const PLUGINS = ['kirbydesk.translatewizard', 'kirbydesk.contentwizard'];

	public static function file(): string
	{
		return dirname(kirby()->root('site')) . '/.env';
	}

	/**
	 * Declared keys of all installed AI plugins.
	 * @return list<array{env: string, option: string, plugin: string, label: string, help: ?string}>
	 */
	public static function declared(): array
	{
		$list = [];
		foreach (self::PLUGINS as $plugin) {
			$secrets = kirby()->option($plugin . '.secrets');
			if (!is_callable($secrets)) continue;

			foreach ($secrets() as $secret) {
				if (!preg_match('/^[A-Z][A-Z0-9_]*$/', $secret['env'] ?? '')) continue;
				$list[] = [
					'env'    => $secret['env'],
					'option' => $plugin . '.' . ($secret['option'] ?? ''),
					'plugin' => $plugin,
					'label'  => (string) ($secret['label'] ?? $secret['env']),
					'help'   => $secret['help'] ?? null,
				];
			}
		}
		return $list;
	}

	/** Value of a variable in the .env file ('' if missing). */
	public static function get(string $env): string
	{
		return self::read()[$env] ?? '';
	}

	/** @return array<string, string> */
	public static function read(): array
	{
		$file = self::file();
		if (!is_file($file)) return [];

		$values = [];
		foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
			if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
			[$key, $value] = explode('=', $line, 2);
			$values[trim($key)] = trim($value);
		}
		return $values;
	}

	/**
	 * Set a variable in the .env file: replaces its line, or appends it
	 * with a comment. Other lines and comments stay untouched.
	 */
	public static function write(string $env, string $value, string $comment = ''): void
	{
		if (!preg_match('/^[A-Z][A-Z0-9_]*$/', $env)) {
			throw new InvalidArgumentException('Invalid variable name');
		}

		$value = trim(str_replace(["\r", "\n"], '', $value));
		$file  = self::file();

		if (is_file($file) && !is_writable($file) || !is_file($file) && !is_writable(dirname($file))) {
			throw new RuntimeException('The .env file is not writable');
		}

		$content = is_file($file) ? file_get_contents($file) : '';
		$line    = $env . '=' . $value;
		$pattern = '/^' . preg_quote($env, '/') . '\s*=.*$/m';

		if (preg_match($pattern, $content)) {
			$content = preg_replace($pattern, $line, $content, 1);
		} else {
			if ($content !== '' && !str_ends_with($content, "\n")) $content .= "\n";
			$content .= ($content !== '' ? "\n" : '') . ($comment !== '' ? '# ' . $comment . "\n" : '') . $line . "\n";
		}

		file_put_contents($file, $content, LOCK_EX);
	}

	/** Masked form for the panel, e.g. "••••••••a1b2". */
	public static function mask(string $value): string
	{
		return $value === '' ? '' : str_repeat('•', 8) . mb_substr($value, -4);
	}

	/**
	 * Status of all declared keys for the panel — never the key itself.
	 * `source`: 'config' (plugin option differs from .env, config wins),
	 * 'env' (from .env), or null (not set).
	 */
	public static function status(): array
	{
		$env = self::read();
		$out = [];
		foreach (self::declared() as $secret) {
			$fromEnv    = $env[$secret['env']] ?? '';
			$fromConfig = kirby()->option($secret['option']);
			$fromConfig = is_string($fromConfig) ? $fromConfig : '';

			$source = match (true) {
				$fromConfig !== '' && $fromConfig !== $fromEnv => 'config',
				$fromEnv !== ''                                => 'env',
				default                                        => null,
			};

			$out[] = [
				'env'    => $secret['env'],
				'label'  => $secret['label'],
				'help'   => $secret['help'],
				'source' => $source,
				'masked' => self::mask($source === 'config' ? $fromConfig : $fromEnv),
			];
		}
		return $out;
	}

	/** Only admins may see and change keys. */
	public static function allowed(): bool
	{
		return kirby()->user()?->isAdmin() === true;
	}

	/** Whether $env was declared by an installed AI plugin. */
	public static function isDeclared(string $env): bool
	{
		return in_array($env, array_column(self::declared(), 'env'), true);
	}
}
