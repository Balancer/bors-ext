<?php

class web_twitter
{
	// Генерация метаданных для Twitter Cards
	// Использование: aviaport_config
	static function meta_summary($object)
	{
		// Формат: <meta name="twitter:site" content="@AviaPort">
		$metas = array();
		$metas['twitter:card'] = 'summary';
		$metas['twitter:title'] = $object->title();

		if($site = $object->get('twitter_site'))
			$metas['twitter:site'] = $site;

		if($author = $object->get('author'))
			if($twitter = $autor->get('twitter'))
				$metas['twitter:creator'] = $twitter;

		if($desc = $object->description())
			$metas['twitter:description'] = $desc;

		if($image = $object->get('image'))
			$metas['twitter:image:src'] = $image->thumbnail('400x400(up)')->url();

		return $metas;
	}

	static function import_bb($url)
	{
		$html = blib_http::get($url);

		file_put_contents('test.html', $html);

		$dom= new DOMDocument('1.0', 'UTF-8');
		@$dom->loadHTML($html);
		$dom->encoding="UTF-8";
		$xpath = new DOMXPath($dom);



		$result = array();

		// Чистим мусор
		foreach(array(
			"//div[contains(@class, 'replies-to')]",
			"//span[contains(@class, 'u-isHiddenVisually')]",
		) as $query)
			foreach($xpath->query($query) as $node)
				$node->parentNode->removeChild($node);

		$ava = $xpath->query('//a[contains(@class,"js-user-profile-link")]')->item(0);
		$img_src = $xpath->query('//img[@class="avatar js-action-profile-avatar"]')->item(0)->getAttribute('src');
		$twitter_name = $xpath->query('//span[@class="username js-action-profile-name"]')->item(0)->nodeValue;
		$full_name = $xpath->query('//strong[contains(@class, "fullname")]')->item(0)->nodeValue;
		$text = $xpath->query('//p[contains(@class,"tweet-text")]')->item(0)->nodeValue;

		$bb_code = "[round_box][img={$img_src} 100x100 left flow nohref resize][h][a href=\"{$url}\"]{$full_name} [small]{$twitter_name}[/small][/a][/h]
[big]{$text}[/big]

[span class=\"transgray\"][reference]".bors_external_feeds_entry::url_host_link($url)."[/reference][/span][/round_box]";

		return $bb_code;
	}

	static function __dev()
	{
		echo self::import('https://twitter.com/navalny/status/477862956274057216');
	}
}
