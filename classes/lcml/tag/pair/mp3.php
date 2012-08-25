<?php

/**
	Вставка MP3-ссылки с flash-проигрывателем
	Пример использования: [mp3]http://airbase.ru/events/2012/0403-fire-moscow-city/skyscraper_00m_00s__20m_02s_40h.mp3[/mp3]
	Ссылка с примером: http://balancer.ru/g/p2770643
*/

class lcml_tag_pair_mp3 extends bors_lcml_tag_pair
{
	function html($mp3, &$params = array())
	{
		$title = defval($params, 'title', basename($mp3));
		// via http://www.labnol.org/internet/design/html-embed-mp3-songs-podcasts-music-in-blogs-websites/2232/
		// Пример использования: http://balancer.ru/g/p2770643
		return "<embed type=\"application/x-shockwave-flash\" flashvars=\"audioUrl=$mp3\" "
			."src=\"http://www.google.com/reader/ui/3523697345-audio-player.swf\" width=\"640\" height=\"27\" quality=\"best\">"
			."</embed><br/>"
			."<a href=\"$mp3\" class=\"transgray\">Скачать: {$title}</a>";
	}
}
