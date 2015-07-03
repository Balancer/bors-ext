<?php

class assets_codemirror extends bors_asset
{
	// assets_codemirror::load('htmlmixed', '')
	// http://stackoverflow.com/questions/6809289/when-i-edit-the-code-in-a-textarea-using-codemirror-how-to-reflect-this-into-ano
	// http://stackoverflow.com/questions/16804771/codemirror-3-0-format-preloaded-textarea-code
	// http://stackoverflow.com/questions/9374894/can-codemirror-find-textareas-by-class

	static function load($modes, $els, $params)
	{
		$path = config('codemirror.path');
		bors_use($path.'/lib/codemirror.js');
		bors_use($path.'/lib/codemirror.css');
		foreach(explode(',', $modes) as $mode)
			bors_use($path.'/mode/'.$mode.'/'.$mode.'.js');

		$height = popval($params, 'height');
		$mode   = popval($params, 'mode', 'text/html');
		if($theme	= popval($params, 'theme'))
			bors_use($path.'/theme/'.$theme.'.css');

		jquery::on_ready("
			$({$els}).each(function(idx){
				$(this).attr('id', 'codemirror-'+idx)
				CodeMirror.fromTextArea(document.getElementById('codemirror-' + idx), {
					mode: '$mode',
					lineNumbers: true"
.($height ? ",\n\t\t\t\t\theight: $height" : '')
.($theme  ? ",\n\t\t\t\t\ttheme: '$theme'" : '')
."
//					lineWrapping: true,
				})
			})
		");
	}
}
