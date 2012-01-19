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
		return bors_lcml_tags_pairs_youtube::html($id);
	}
}
