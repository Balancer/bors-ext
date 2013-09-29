<?php

class bors_pages_zim extends bors_page
{
	function can_be_empty() { return false; }

	function is_loaded()
	{
		$path = bors()->request()->path();
		if(preg_match('!^(.+)/$!', $path, $m))
			$path = $m[1].'.txt';

		$file = $this->webroot().$path;
		if(!file_exists($file) || !is_file($file))
			return false;

		$this->parse($file);

		//TODO: Поменять потом на проверку тегов
		if(preg_match('/@skip/', $this->source))
			return false;

		return true;
	}

	function parse($file)
	{
		$text = file_get_contents($file);
		if(preg_match("!^(.+?)\n\n(.+)$!s", $text, $m))
			list($this->head_raw, $this->body_raw) = array_slice($m, 1, 2);
		else
			bors_throw("Zim file parse error: can't split header for ".$file);

//		var_dump($this->body_raw);
		if(preg_match("!^\s*={6} (.+?) ={6}\n(.+)$!s", $this->body_raw, $m))
			list($this->title, $this->source) = array_slice($m, 1, 2);
		else
			bors_throw("Zim file parse error: can't get title for ".$file);
	}

	function source() { return $this->source; }
}
