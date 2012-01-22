<?php

class bors_external_flickr extends bors_external_meta
{
	static function parse_links($text)
	{
		// http://www.flickr.com/photos/39045986@N08/6739212879/
		$text = preg_replace('!^\s*https?://[^/]*flickr\.com/(#/)?photos/\w+@\w+/(\d+)/\S*\s*$!mi', '[flickr]$2[/flickr]', $text);
		return $text;
	}
}
