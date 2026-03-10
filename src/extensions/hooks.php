<?php return [

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