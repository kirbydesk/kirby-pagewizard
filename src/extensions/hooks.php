<?php return [

	/* -------------- Hooks --------------*/
	'file.create:after' => function ($file) {
  	if ($file->type() === 'image' && !$file->content()->get('imageRatio')->isNotEmpty()) {
			$file->update(['imageRatio' => '4/3']);
    }
  }
];