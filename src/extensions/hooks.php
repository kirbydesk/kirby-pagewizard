<?php return [

	/* -------------- Soft hyphens, Reload on Save --------------*/
	'page.render:after' => function (string $contentType, string $html): string {
		if ($contentType !== 'html') return $html;

		// soft hyphens: "[-]" in any text (and an "&shy;" a text field masked)
		// becomes a place to break a long word – invisible unless the word is
		// broken there; in the head, scripts (e.g. the FAQ's structured data)
		// and styles it is only removed
		if (str_contains($html, '[-]') || str_contains($html, '&amp;shy;')) {
			$parts = preg_split('~(<head\b.*?</head>|<script\b.*?</script>|<style\b.*?</style>|<textarea\b.*?</textarea>)~is', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
			foreach ($parts as $i => $part) {
				$parts[$i] = $i % 2 === 1
					? str_replace('[-]', '', $part)
					: str_replace(['[-]', '&amp;shy;'], '&shy;', $part);
			}
			$html = implode('', $parts);
		}

		if (option('kirbydesk.pagewizard.reloadOnSave') !== true) return $html;

		$siteUrl = kirby()->url();
		$script = <<<SCRIPT
<script data-reload-on-save>
(function(){if(!("BroadcastChannel" in window))return;var bc=new BroadcastChannel("{$siteUrl}");bc.onmessage=function(e){if(e.data==="content/saved")window.location.reload()};})();
</script>
SCRIPT;

		return str_replace('</head>', $script . '</head>', $html);
	},

	/* -------------- Hooks --------------*/
	'site.update:after' => function ($newSite, $oldSite) {
		static $running = false;
		if ($running) return;

		$raw = $newSite->content()->sharedblocks()->value();
		if (empty($raw)) return;

		$blocks   = json_decode($raw, true);
		$modified = false;

		foreach ($blocks as &$block) {
			$name = trim($block['content']['sharedname'] ?? '');
			if (empty($name)) {
				$type  = $block['type'] ?? 'block';
				$block['content']['sharedname'] = date('Y-m-d H:i:s');
				$modified = true;
			}
		}

		if ($modified) {
			$running = true;
			$newSite->update(['sharedblocks' => json_encode($blocks)]);
			$running = false;
		}
	},

	'file.create:after' => function ($file) {
		if ($file->type() === 'image' && !$file->content()->get('imageRatio')->isNotEmpty()) {
			$width  = $file->width();
			$height = $file->height();

			if (!$width || !$height) return;

			$actual = $width / $height;

			$ratios = [
				'1/1'  => 1 / 1,
				'16/9' => 16 / 9,
				'10/8' => 10 / 8,
				'21/9' => 21 / 9,
				'7/5'  => 7 / 5,
				'4/3'  => 4 / 3,
				'5/3'  => 5 / 3,
				'3/2'  => 3 / 2,
				'3/1'  => 3 / 1,
			];

			$closest = null;
			$minDiff = PHP_FLOAT_MAX;

			foreach ($ratios as $key => $value) {
				$diff = abs($actual - $value);
				if ($diff < $minDiff) {
					$minDiff = $diff;
					$closest = $key;
				}
			}

			$tolerance = $actual * 0.02;
			$result = ($minDiff <= $tolerance) ? $closest : 'auto';

			$file->update(['imageRatio' => $result]);
		}
	}
];