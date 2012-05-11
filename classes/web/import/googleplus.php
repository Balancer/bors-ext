<?php

class web_import_googleplus extends web_import_common
{
	static function extract_star_tags(&$text, &$tags)
	{
		if(preg_match_all('/(^|\s|>)\*([\wа-яА-ЯёЁ]+)/u', $text, $matches))
		{
			foreach($matches[2] as $m)
			{
				$tags[] = trim(common_keyword::loader(str_replace('_', ' ', $m))->synonym_or_self()->title());
				$text = preg_replace("/(\S+ )\s*\*".preg_quote($m)."/", '$1', $text);
			}
		}

		if(preg_match('/^(#([\wа-яА-ЯёЁ]+)\s+)+[А-ЯЁA-Z].{5,}/u', strip_tags($text), $m))
		{
			// Если это хэш-теги в начале текста, а потом начинается предложение, то их вырезаем.
			while(preg_match('/^#([\wа-яА-ЯёЁ]+)\s+[А-ЯЁA-Z#]/u', strip_tags($text), $m))
			{
				$tags[] = trim(common_keyword::loader(str_replace('_', ' ', $m[1]))->synonym_or_self()->title());
				$text = preg_replace("/(^|>)#".preg_quote($m[1])."\s+/", '$1', $text);
			}
		}
	}


	static function extract_sharp_tags(&$text, &$tags)
	{
//		echo "Parse sharp '$text'\n\n\n";
		if(preg_match_all('/( |^|"|«|>)#([\wа-яА-ЯёЁ\-]+)/um', $text, $matches))
		{
			foreach($matches[2] as $m)
			{
				$tags[] = trim(common_keyword::loader(str_replace('_', ' ', $m))->synonym_or_self()->title());
				$text = preg_replace('/( |^|"|«|>)#('.preg_quote($m).")/", '$1$2', $text);
			}
		}

		if(preg_match_all('/#[«"]([^»"]+)["»]/um', $text, $matches))
		{
			foreach($matches[1] as $m)
			{
				$tags[] = '«'.trim(common_keyword::loader(str_replace('_', ' ', $m))->synonym_or_self()->title()).'»';
				$text = preg_replace('/#[«"]('.preg_quote($m).')[»"]/', '«$1»', $text);
			}
		}
	}

	static function parse($data)
	{
		$tags = popval($data, 'tags', array());

		extract($data);

		// Фикс странного глюка транляции вида:
		// <div class='content'>#Тася #дети #творчествоТасино творчество в садике :)</div>
		$text = preg_replace('/([a-zа-яё]+)([A-ZА-ЯЁ][a-zа-яё]+[ \.,\!;])/u', '$1 $2$3', $text);

		self::extract_star_tags($text, $tags);
		self::extract_sharp_tags($text, $tags);

//		var_dump($title, $text, $tags); exit();

		$text = preg_replace('!<a [^>]*href="(http://pics\.livejournal\.com/[^"]+)"[^>]*>pics\.livejournal\.com</a>!e', 'lcml("[img]$1[/img]");', $text);
		$text = preg_replace('!<a href="[^"]+youtube[^"]+v=([^"&]+)?"[^>]+>youtube\.com</a>!ie', "lcml('[youtube]$1[/youtube]');", $text);
		$text = preg_replace('!<a href="([^"]+?\.(png|jpg|jpeg|gif))"[^>]+?>[\w\.]+</a>!ie', "lcml('[img]$1[/img]');", $text);
		$text = preg_replace('!<a href="https?://picasaweb.google.com/lh/photo/([^"\?/]+)\?feat=directlink" rel="nofollow">picasaweb.google.com</a>!ie', "lcml('[picasa]$1[/picasa]');", $text);

		// http://images0-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&resize_h=100&url=https%3A%2F%2Flh4.googleusercontent.com%2F-5ngFI6t9dHo%2FT5xqzi1BbtI%2FAAAAAAAAHAA%2Ffg7HBClefn8%2Fs0-d%2FIMG_26-04-2012_184111.jpg
		// <a href='https://lh4.googleusercontent.com/-5ngFI6t9dHo/T5xqzi1BbtI/AAAAAAAAHAA/fg7HBClefn8/s0-d/IMG_26-04-2012_184111.jpg' target='_blank'><img src='http://images0-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&resize_h=100&url=https%3A%2F%2Flh4.googleusercontent.com%2F-5ngFI6t9dHo%2FT5xqzi1BbtI%2FAAAAAAAAHAA%2Ffg7HBClefn8%2Fs0-d%2FIMG_26-04-2012_184111.jpg' height='100'/> IMG_26-04-2012_184111.jpg</a>
		$text = preg_replace('!<a href=[\'"](https?://[^/]+?\.googleusercontent\.com/[^\'"]+?)[\'"][^>]+>'
				.'<img src=[\'"]http://[^/]+?\.googleusercontent\.com/[^>]+?url='
				.'(https%3A%2F%2F[^>]+?\.googleusercontent.com%2F[^>]+?)[\'"][^>]+?/>([^<]+?)</a>!ie',
			"lcml('[img href=\"$1\" src=\"'.urldecode(\"$2\").'\"]');", $text);

		$text = preg_replace('!(<img[^>]+/>) (\S+)!', "$1<br/>\n $2", $text);

		$text = preg_replace('!^<a href="(http://([^/"]+)[^"]+)"[^>]*>\2</a><br />!mie', "lcml('$1');", $text);
//		var_dump($text); exit();

		if(!empty($link))
			$text .= "<br/><br/><span class=\"transgray\">// Транслировано с ".bors_external_feeds_entry::url_host_link_html($link)."</span>";

		return array(
			'title' => $title,
			'text' => $text,
			'tags' => $tags,
			'bb_code' => $text,
			'markup' => 'bors_markup_html',
		);
	}
}
