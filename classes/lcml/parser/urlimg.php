<?php

/**
	Прямой вывод ссылок вида [url=...][img]...[/img][/url]
*/

class lcml_parser_urlimg extends bors_lcml_parser
{
	function html($text)
	{
		$text = preg_replace('!\[url=([^\]]+)\]\[img\]([^\[]+)\[/img\]\[/url\]!i', '[img="$2" href="$1"]', $text);

		return $text;
	}

	function text($text)
	{
		return $this->html($text);
	}
}
