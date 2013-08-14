<?php

class web_import_image
{
	function _store_dir_def() { bors_throw('Not defined store_dir'); }
	function _store_url_def() { bors_throw('Not defined store_url'); }

	static function normalize_url($url)
	{
		// http://www.palal.net/blogposts/20130601-favelas/dona%20marta/IMG_9636.JPG
		while(preg_match('/%\w\w/', $url))
			$url = urldecode($url);

		while(preg_match('/&amp;/', $url))
			$url = bors_entity_decode($url);

		return $url;
	}

	static function storage_place_rel($url)
	{
		extract(parse_url(self::normalize_url($url)));
		$host = preg_replace('/^(ftp|www)\./', '', $host);
		$host = preg_replace('/:\d+$/', '', $host);

		$host_parts = array_reverse(explode('.', $host));
		array_unshift($host_parts, $host_parts[0]);
		$host_parts[1] = bors_substr($host_parts[2], 0, 2);

		$path = translite_path($path);

		if(preg_match("!/$!",$path))
			$path .= "index";

		if(!empty($query))
			$path .= ','.str_replace('&','/', $query);

		return join('/', array_filter($host_parts)).$path;
	}

	function __dev()
	{
		echo self::storage_place_rel('http://www.palal.net/blogposts/20130601-favelas/dona%20marta/IMG_9636.JPG');
	}
}
