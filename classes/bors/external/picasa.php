<?php

class bors_external_picasa extends bors_object
{
	static function parse_links($text)
	{
//		https://lh5.googleusercontent.com/-d-Ley4asO24/UWNGvPRBvzI/AAAAAAAANqU/Be3OCgXVWvY/s1152/IMG_08-04-2013_110112.jpg
		$text = preg_replace('!^https?://(lh\d+\.googleusercontent\.com/[^/]+/[^/]+/[^/]+/[^/]+)/[^/]+/(\S+\.(jpg))$!mi', 'http://$1/s0/$2', $text);

//		if(config('is_developer')) { var_dump($text); exit(); }
		return $text;
	}
}
