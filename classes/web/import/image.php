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
		//TODO: Хардкод
		if(preg_match('!^/(uploads|sites)/!', $url))
			$url = 'http://www.balancer.ru'.$url;

		extract(parse_url(self::normalize_url($url)));
		if(empty($host))
//			bors_throw("Can't get host for url ".$url);
			return NULL;

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

	static function find_cached($url)
	{
		// Ищем в новом формате.
		$storage = config('sites_store_path');
		$new_path = $storage.'/'.self::storage_place_rel($url);
		if(file_exists($new_path))
			return $new_path;

		// Если не нашли, роемся в одном из legacy форматов
		$old_path = static::find_legacy_cached($url);
		if($old_path && file_exists($old_path))
			return $old_path;

		return $new_path;
	}

	// Для общего случая — заглушка.
	static function find_legacy_cached($url)
	{
		return NULL;
	}

	function __dev()
	{
		echo self::storage_place_rel('http://www.palal.net/blogposts/20130601-favelas/dona%20marta/IMG_9636.JPG'), PHP_EOL;
		echo self::storage_place_rel('https://pp.vk.me/c540109/c540104/v540104095/d7b2/8zqIgh8Sp3E.jpg'), PHP_EOL;

		echo self::find_cached('http://www.palal.net/blogposts/20130601-favelas/dona%20marta/IMG_9636.JPG'), PHP_EOL;
		echo self::find_cached('https://pp.vk.me/c540109/c540104/v540104095/d7b2/8zqIgh8Sp3E.jpg'), PHP_EOL;
	}
}
