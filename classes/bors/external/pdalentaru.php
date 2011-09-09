<?php

class bors_external_pdalentaru extends bors_object
{
	static function content_extract($url, $limit = 1500)
	{
		$url = str_replace('http://pda.', 'http://', $url);

		return bors_external_lentaru::content_extract($url, $limit);
	}
}
