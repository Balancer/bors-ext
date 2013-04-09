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
				&& preg_match('/(youtube\.|youtu\.be)/', $text))
			$text = bors_external_youtube::parse_links($text);

		if(stripos($text, 'fotki.yandex') !== false)
			$text = bors_external_yandex_fotki::parse_links($text);

		if(stripos($text, 'googleusercontent') !== false)
			$text = bors_external_picasa::parse_links($text);

		return $text;
	}

	function text($text)
	{
		return $this->html($text);
	}
}
