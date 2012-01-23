<?php

class bors_external_youtube extends bors_object
{
	static function id_prepare($id)
	{
		if(preg_match('/youtube/', $id))
		{
			bors_function_include('url/parse');
			$id = bors_url_parse($id, 'query', 'v');
		}

		return $id;
	}

	static function url2html($url)
	{
		$id = self::id_prepare($url);
		return bors_lcml_tag_pair_youtube::html($id);
	}

	static function parse_links($text)
	{
//		$text = preg_replace('!<a href="https?://[^/]+flickr\.com/photos/\w+@\w+/(\d+)/"[^>]+><img src="[^"]+static.flickr.com/[^"]+\.jpg"[^>]+/></a>!is', '[flickr]$1[/flickr]', $text);

		// [url=http://www.youtube.com/watch?v=a8C1iU-xAog]http://www.youtube.com/watch?v=a8C1iU-xAog[/url]
		// [url=http://www.youtube.com/watch?v=JkpO2BliOVg]http://www.youtube.com/watch?v=JkpO2BliOVg[/url]
		$text = preg_replace('!\s*\[url=(http://(www\.)?youtube\.com/watch\?v=[\w\-]+?)\]\1\[/url\]\s*!', "\n$1\n", $text);
		// [url=http://youtube.com/watch?v=cF_rMpiwzQA&search=loituma]http://youtube.com/watch?v=cF_rMpiwzQA&search=loituma[/url]
		$text = preg_replace('!\s*\[url=(http://(www\.)?youtube\.com/watch\?v=[\w\-]+[^\]]+?)\]\1\[/url\]\s*!', "\n$1\n", $text);

		// http://www.youtube.com/watch?v=X76LmiHVFsM&feature=player_embedded
		// http://www.youtube.com/watch?v=TXxcR3qgyYQ&playnext=1&list=PL21AA194D7FBBA2D9
		// https://www.youtube.com/watch?v=21El16OPZoc
		// http://www.youtube.com/watch?feature=player_embedded&v=zZPNaMDD-A8
		$text = preg_replace('!^\s*(https?://[^/]*youtube\.\w+/watch\S+)\s*$!mie', "bors_external_youtube::url2bb('$1');", $text);
		return $text;
	}

	// Трансляция ссылки на YouTube ролик в [youtube]<video-id>[/youtube]
	static function url2bb($url)
	{
//		echo "===".$url."===\n";
		$url = bors_entity_decode($url);
		bors_function_include('url/parse');
		$video_id = bors_url_parse($url, 'query', 'v');
		return "[youtube]{$video_id}[/youtube]";
	}
}
