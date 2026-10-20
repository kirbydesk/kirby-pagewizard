<?php

use Kirby\Cms\App;
use Kirby\Cms\Page;
use Kirby\Toolkit\Str;

return function (App $kirby) {
	// media path relative to the site – like Kirby's own media routes
	$index = $kirby->url('index');
	$media = $kirby->url('media');
	$media = Str::startsWith($media, $index) ? trim(Str::after($media, $index), '/') : 'media';

	return [

		/* -------------- Runtime vars.css and uploaded fonts --------------*/
		// Before the password interceptor below: the protected page needs its
		// styles, too. Both are written into the media folder on first request.
		[
			'pattern' => $media . '/pagewizard/vars.(:alphanum).css',
			'method'  => 'GET',
			'action'  => fn (string $hash) => pwConfig::varsResponse($hash),
		],
		[
			'pattern' => $media . '/pagewizard/fonts/(:alphanum)/(:any)',
			'method'  => 'GET',
			'action'  => fn (string $hash, string $file) => pwConfig::fontResponse($hash, $file),
		],

		/* -------------- Password Protection: POST handler --------------*/
		[
			'pattern'  => 'pagewizard/login',
			'language' => '*',
			'method'   => 'POST',
			'action'   => function () {
				$hash = password_hash(get('password'), PASSWORD_BCRYPT);
				kirby()->session()->set('kirbydesk.pagewizard.password-hash', $hash);
				kirby()->response()->redirect(get('redirect'));
			}
		],

		/* -------------- Password Protection: GET interceptor --------------*/
		[
			'pattern' => '(:all)',
			'method'  => 'GET',
			'action'  => function (string $uid) {
				$password = option('kirbydesk.pagewizard.protected');

				// Bypass: not configured or logged-in Kirby user
				if (!$password || kirby()->user()) {
					return $this->next();
				}

				$query       = get();
				$redirectUrl = $uid . (empty($query) ? '' : '?' . http_build_query($query));

				$passwordIncorrect = false;
				$session           = kirby()->session();
				$hash              = $session->get('kirbydesk.pagewizard.password-hash');

				if ($hash) {
					if (password_verify($password, $hash)) {
						return $this->next();
					} else {
						$passwordIncorrect = true;
						$session->remove('kirbydesk.pagewizard.password-hash');
					}
				}

				$page = new Page([
					'slug'     => 'protected',
					'template' => 'protected',
					'content'  => [
						'title'             => t('pw.login.title', 'Protected'),
						'redirect'          => url($redirectUrl),
						'passwordIncorrect' => $passwordIncorrect,
					]
				]);

				return $page->render();
			}
		],
	];
};
