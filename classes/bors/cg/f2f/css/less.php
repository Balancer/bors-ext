<?php

// Используется leafo/lessphp

class bors_cg_f2f_css_less extends bors_cg_f2f
{
	var $mime_type = 'text/css';

	function content()
	{
		$relative_path = '/f2f/'.$this->id().'.less';
		$src = $_SERVER['DOCUMENT_ROOT'].'/_cg'.$relative_path;

		if(!file_exists($src))
			$src = bors::find_webroot($relative_path);

		if(!file_exists($src))
			throw new Exception("Can't find ".$relative_path);

		$dst = $_SERVER['DOCUMENT_ROOT'].'/_cg/f2f/'.$this->id().'.less.css';
		$less = new lessc;
//		$less->checkedCompile($src, $dst);
		return $less->compileFile($src);
//		return file_get_contents($dst);
	}
}
