<?php

function lcml_external_code_ext($text)
{
	if(stripos($text, 'flickr') !== false)
		$text = bors_external_flickr::parse_links($text);

	if(stripos($text, 'vimeo') !== false)
		$text = bors_external_vimeo::parse_links($text);

	return $text;
}
