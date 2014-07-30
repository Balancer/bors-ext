<?php

// Используется leafo/lessphp

class bors_cg_f2f_css_less extends bors_cg_f2f
{
	var $mime_type = 'text/css';

	function content()
	{
		$src = $_SERVER['DOCUMENT_ROOT'].'/_cg/f2f/'.$this->id().'.less';
		$dst = $_SERVER['DOCUMENT_ROOT'].'/_cg/f2f/'.$this->id().'.less.css';
		$less = new lessc;
//		$less->checkedCompile($src, $dst);
		return $less->compileFile($src);
//		return file_get_contents($dst);
	}
}
