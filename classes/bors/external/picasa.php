<?php

class bors_external_picasa extends bors_object
{
	static function parse_links($text)
	{
//		https://lh5.googleusercontent.com/-d-Ley4asO24/UWNGvPRBvzI/AAAAAAAANqU/Be3OCgXVWvY/s1152/IMG_08-04-2013_110112.jpg
//		https://lh4.googleusercontent.com/-DF62qChbqvo/U-Tp1scEsBI/AAAAAAAAZsI/idEskUrG52o/w1129-h847-no/2014-07-01%2B04.58.16.jpg
		$text = preg_replace('!^https?://(lh\d+\.googleusercontent\.com/[^/]+/[^/]+/[^/]+/[^/]+)/[^/]+/(\S+\.(jpg))$!mi', 'http://$1/s0/$2', $text);
//		[http://lh6.googleusercontent.com/-iWl9tPh1Wss/U-TsANQ3z9I/AAAAAAAAZsU/oJH-ha3RpYg/s0/CAM00919.jpg]
		$text = preg_replace('!\[https?://(lh\d+\.googleusercontent\.com/[^/]+/[^/]+/[^/]+/[^/]+)/[^/]+/(\S+\.(jpg))\]!mi', '[http://$1/s0/$2]', $text);

//		if(config('is_developer')) { var_dump($text); exit(); }
		return $text;
	}
}
