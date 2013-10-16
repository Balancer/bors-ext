<?php

class bors_lcml_helper
{
	static function box($object, $params = array())
	{
		$image_url = $object->get('image_url');

		if(!$image_url)
			$image_url = object_property($object->get('image'), 'url');

		if($image_url)
		{
			// Если делать ресайз, доработать, чтобы локальные не тянулись по curl в http://www.balancer.ru/g/p3264778
			$img = "[img={$image_url} 200x200 left flow nohref resize]";
		}
		else
			$img = '';

		if(!($url = defval($params, 'url')))
			$url = $object->url();

		if(!($description = defval($params, 'description')))
			$description = $object->description();

		if(!($reference = @$params['reference']))
			$reference = (!empty($more) ? ec('Дальше — '):'').bors_external_feeds_entry::url_host_link($url);

		$bb = "[round_box]{$img}[h][a href=\"{$url}\"]{$object->title()}[/a][/h]%%description%%[span class=\"transgray\"][reference]{$reference}[/reference][/span][/round_box]";

		$bb = trim(bors_close_tags(bors_close_bbtags($bb)));

		$html = restore_format(lcml($bb));
		$html = str_replace('%%description%%', $description, $html);
		$html = preg_replace("/\n+/", '', $html);
//		if(config('is_developer')) { print_dd($bb); var_dump($html); exit('bbcode'); }
//		if(config('is_developer')) { print_dd($bb); }
		return $html;
	}
}
