<?php

class bors_external_flickr extends bors_external_meta
{
	static function parse_links($text)
	{
		$text = preg_replace('!<a href="https?://[^/]+flickr\.com/photos/\w+@\w+/(\d+)/"[^>]+><img src="[^"]+static.flickr.com/[^"]+\.jpg"[^>]+/></a>!is', '[flickr]$1[/flickr]', $text);

		// http://www.flickr.com/photos/39045986@N08/6739212879/
		$text = preg_replace('!^\s*https?://[^/]*flickr\.com/(#/)?photos/\w+@\w+/(\d+)/?\S*\s*$!mi', '[flickr]$2[/flickr]', $text);

		// http://www.flickr.com/photos/ju_cooper/6701868497/
		// http://www.flickr.com/photos/sjc1969/8784722102/ — http://www.balancer.ru/g/p3155955
		// https://www.flickr.com/photos/jeroenakkermans/14563130649/
		$text = preg_replace('!^\s*https?://[^/]*flickr\.com/(#/)?photos/(\w+)/(\d+)/?\s*$!mi', '[flickr user="$2"]$3[/flickr]', $text);
		return $text;
	}
}
