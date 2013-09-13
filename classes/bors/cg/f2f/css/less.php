<?php

class bors_cg_f2f_css_less extends bors_cg_f2f
{
	var $mime_type = 'text/css';

	function content()
	{
		$this->uses('composer');
		require "lessc.inc.php";
		echo $file = $_SERVER['DOCUMENT_ROOT'].'/_cg/f2f/'.$this->id();
		
		var_dump($this->id(), file_get_contents($file));
	}
}
