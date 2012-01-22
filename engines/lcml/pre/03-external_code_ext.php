<?php

function lcml_external_code_ext($text)
{
	if(stripos($text, 'flickr') !== false)
		$text = bors_external_flickr::parse_links($text);

	return $text;
}
