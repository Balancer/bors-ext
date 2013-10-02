<?php

// Отработка поддержки: http://forums.balancer.ru/rules/

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

		//TODO: Поменять потом на проверку настоящих тегов
		if(preg_match('/(@skip|@hidden)/', $this->source))
			return false;

		if(preg_match('/(@under_?construction)/', $this->source))
			$this->set_attr('is_under_construction', true);

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

	function body()
	{
		return $this->zim_markup($this->source());
	}

	function zim_markup($text)
	{
		$text = preg_replace("!^(Created.+)\n!", "<i class=\"transgray\"><small>$1</small></i>\n", $text);
		$text = preg_replace("@(?!:)//(.+?[^:])//@s", "<i>$1</i>\n", $text);
		$text = preg_replace("!\*\*(.+?)\*\*!s", "<b>$1</b>\n", $text);
		$text = preg_replace_callback("!(\[(\w+)[^\]]*\].*\[/\\2\])!s", function($code) { return lcml_bb($code[1]); }, $text);
		$text = preg_replace("!^====== (.+?) ======$!m", "<h1>$1</h1>\n", $text);
		$text = preg_replace("!^===== (.+?) =====$!m", "<h2>$1</h2>\n", $text);
		$text = preg_replace("!^==== (.+?) ====$!m", "<h3>$1</h3>\n", $text);
		$text = preg_replace("!^=== (.+?) ===$!m", "<h4>$1</h4>\n", $text);
		$text = preg_replace("!^== (.+?) ==$!m", "<h5>$1</h5>\n", $text);
		$text = preg_replace("!^= (.+?) =$!m", "<h6>$1</h6>\n", $text);
		$text = preg_replace("!\[\[(.+?)\|(.+?)\]\]!", "<a href=\"$1\">$2</a>", $text);

		$text = preg_replace("!(^\* (.+?)$)+!m", "<li>$2</li>", $text);
#		$text = preg_replace("!\n(?!<ul)([^\n]+)\n<li>!s", "$1\n<ul>\n<li>", $text);

		$text = preg_replace("/(?:^|\n)([^<].+?[^>])(?:($|\n){2,})/", "<p>$1</p>\n", $text);
		return $text;
	}
}
