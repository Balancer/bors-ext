<?php

// Используется leafo/lessphp

class bors_cg_f2f_css_less extends bors_cg_f2f
{
	var $mime_type = 'text/css';

	function content()
	{
		$relative_path = '/f2f/'.$this->id().'.less';
		$src = $_SERVER['DOCUMENT_ROOT'].'/_cg'.$relative_path;
//		$dst = $_SERVER['DOCUMENT_ROOT'].'/_cg'.$relative_path.'.css';

		if(!file_exists($src))
			$src = bors::find_webroot($relative_path);

		if(!file_exists($src))
			throw new Exception("Can't find ".$relative_path);

//		$cache = bors_cache_fast('f2f_css_less', $src);
//		if(filemtime($src) <= )

		$less = new lessc;
		$css = $less->compileFile($src);

//		file_put_contents($dst, $css);

		return $css;
	}
}
