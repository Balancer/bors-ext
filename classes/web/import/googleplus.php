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

//		if(config('is_developer')) { print_dd($text); exit(); }

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

		// Фотки подменяем крупными и с эффектом:
		// http://www.balancer.ru/g/p3145617
		// <a href="https://plus.google.com/photos/113730597040634449637/albums/5576590784308938497/5877209219079836882?authkey=CJ_yjtjAopPSUg">
		//	<img src='http://lh5.googleusercontent.com/-WxrnImx-5FI/UZAKpV3nlNI/AAAAAAAAPFA/Jd_T1fpi_3g/h371/20130511-1757-img_3963.jpg' width='247' height='371' style="border: none;" /></a>
		// <a href="https://plus.google.com/photos/113730597040634449637/albums/5858713556411311985/5858713555572055138">
		//	<img src='http://lh6.googleusercontent.com/-mqIzssakWyQ/UU5U8CCjXGI/AAAAAAAANPk/J1Hj00IUGXY/h371/photo.jpg' width='222' height='371' style="border: none;" /></a>

		$text = preg_replace_callback('!<a href="https?://plus\.google\.com/photos/\d+/albums/\d+[^"]*?">'
				."<img src='(http://lh\d+\.googleusercontent\.com/[^/]+/[^/]+/[^/]+/[^/]+)/[^/]+/(.+?)'[^>]+></a>!i",
			function($matches)
			{
				return lcml("[img={$matches[1]}/s0/{$matches[2]}]");
			}, $text);

		// http://www.balancer.ru/g/p2787779
		// <a href="http://lh5.googleusercontent.com/-LPjy0ZM8IK0/T5L1RslE6HI/AAAAAAAAGwE/zHUkTDAxReA/s0/20120421-1855-img_0111.jpg">
		//	<img src="http://lh5.googleusercontent.com/-LPjy0ZM8IK0/T5L1RslE6HI/AAAAAAAAGwE/zHUkTDAxReA/s640/20120421-1855-img_0111.jpg" /></a>

		$text = preg_replace_callback("!<a href='(https?://lh\d+\.googleusercontent\.com/[^/]+/[^/]+/[^/]+/[^/]+)/[^/]+/(.+?)\.(jpg|jpeg|png|gif)'[^>]*>"
				."<img src='https?://[^/]+google[^>]+>(.+?)</a>!i",
			function($matches)
			{
				return lcml("[img={$matches[1]}/s0/{$matches[2]} description=\"{$matches[3]}\" no_lcml_description=true]");
			}, $text);

//		if(config('is_developer')) { echo debug_trace(); print_dd($text); exit(); }

//		<p class='attachment photo'>     <a href='https://lh3.googleusercontent.com/-xF4QASaJ6Fs/T8CbBC8SJDI/AAAAAAAAHv0/aEp8_CYWj7Y/s0-d/IMG_4689-crop-resize.JPG' target='_blank'><img src='https://images0-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&resize_h=100&url=https%3A%2F%2Flh3.googleusercontent.com%2F-xF4QASaJ6Fs%2FT8CbBC8SJDI%2FAAAAAAAAHv0%2FaEp8_CYWj7Y%2Fs0-d%2FIMG_4689-crop-resize.JPG' height='100'/><br/>  IMG_4689-crop-resize.JPG</a>     </p>
		$text = preg_replace('!<p class=\'attachment photo\'>\s+<a href=\'https?://(.+?)/s0-d/(.+?)\'\s+target=\'_blank\'><img src=\'.+?\'.+?>(.+)?</a>\s+</p>!s',
			"<a href=\"http://$1/s0/$2\"><img src=\"http://$1/s640/$2\" /></a><br/>", $text);

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
