<?php

/**
	Вставка MP3-ссылки с flash-проигрывателем
	Примеры использования:

		[mp3]http://airbase.ru/events/2012/0403-fire-moscow-city/skyscraper_00m_00s__20m_02s_40h.mp3[/mp3]

		[mp3 title="Гарик Сукачев - Свободу Анжеле Девис"]http://cs4541v4.vk.me/u51740329/audios/242ed5421599.mp3[/mp3]

		[mp3=http://cs4541v4.vk.me/u51740329/audios/242ed5421599.mp3]Гарик Сукачев - Свободу Анжеле Девис[/mp3]

	Ссылка с примером: http://balancer.ru/g/p2770643
*/

class lcml_tag_pair_mp3 extends bors_lcml_tag_pair
{
	function html($content, &$params = array())
	{
		if(!empty($params['mp3']))
		{
			$mp3 = $params['mp3'];
			$title = $content;
		}
		else
		{
			$mp3 = $content;
			$title = defval($params, 'title', basename($mp3));
		}

		// via http://www.labnol.org/internet/design/html-embed-mp3-songs-podcasts-music-in-blogs-websites/2232/
		// Пример использования: http://balancer.ru/g/p2770643

//		var_dump($mp3); exit();

		$html = jquery_jplayer::html(array('mp3' => $mp3, 'title' => $title));

		return "{$html}<a href=\"$mp3\" class=\"transgray\">Скачать: {$title}</a>";
	}
}
