<?php

use Kirby\Cms\Page;

return [

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
