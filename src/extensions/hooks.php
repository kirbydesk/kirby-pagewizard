<?php return [

	/* -------------- Hooks --------------*/
	'file.create:after' => function ($file) {
  	if ($file->type() === 'image' && !$file->content()->get('imageRatio')->isNotEmpty()) {
			$file->update(['imageRatio' => '1/1']);
    }
  }
];