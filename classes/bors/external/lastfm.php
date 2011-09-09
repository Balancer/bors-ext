<?php

class bors_external_lastfm extends bors_object
{
	static function content_extract($url, $limit=1500)
	{
		if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $url))
			return array('bbshort' => "[img url=\"$url\" 468x468]", 'tags' => array());

		$html = bors_lib_http::get_cached($url, 7200);
		$meta = bors_lib_html::get_meta_data($html);
//		echo "'$url':<br/>"; print_dd($meta); exit();

		$title = @$meta['og:title'];
		if(!$title)
			$title = @$meta['title'];

		$img = @$meta['og:image'];
		if(!$img)
			$img = @$meta['img_src'];

		$description = "[url=$url][img {$img} 300x300 nohref][/url]";

		$description = clause_truncate_ceil($description, $limit);

		$bbshort = "[b][url={$url}]{$title}[/url][/b]

{$description}

// ".ec("Подробнее: ").bors_external_feeds_entry::url_host_link($url);

		$tags = array('музыка');
		return compact('tags', 'bbshort');
	}
}
