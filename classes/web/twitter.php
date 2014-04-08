<?php

class web_twitter
{
	// Генерация метаданных для Twitter Cards
	// Использование: aviaport_config
	static function meta_summary($object)
	{
		// Формат: <meta name="twitter:site" content="@AviaPort">
		$metas = array();
		$metas['twitter:card'] = 'summary';
		$metas['twitter:title'] = $object->title();

		if($site = $object->get('twitter_site'))
			$metas['twitter:site'] = $site;

		if($author = $object->get('author'))
			if($twitter = $autor->get('twitter'))
				$metas['twitter:creator'] = $twitter;

		if($desc = $object->description())
			$metas['twitter:description'] = $desc;

		if($image = $object->get('image'))
			$metas['twitter:image:src'] = $image->thumbnail('400x400(up)')->url();

		return $metas;
	}
}
