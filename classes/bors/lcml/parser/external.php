<?php

/**
	Сворачивание стороннего HTML-кода или ссылок в базовые тэги
	(например, YouTube-html в [youtube]<video-id>[/youtube])
*/

class bors_lcml_parser_external extends bors_lcml_parser
{
	function html($text)
	{
		if(!config('lcml_external_parse_youtube_disable')
				&& stripos($text, 'youtube.') !== false)
			$text = bors_external_youtube::parse_links($text);

		return $text;
	}

	function text($text)
	{
		return $this->html($text);
	}
}
