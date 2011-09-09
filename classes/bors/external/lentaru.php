<?php

class bors_external_lentaru extends bors_object
{
	static function content_extract($url, $limit = 1500)
	{
		$html = bors_lib_http::get_cached($url, 7200);
		$html = preg_replace('/<!--.+?-->/', '', $html);
		$dom = new DOMDocument('1.0', 'utf-8');
		@$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);

		$tags = array();
		$meta = bors_lib_html::get_meta_data($html);

		$title = $meta['title'];
		$description = $meta['description'];

		if($el = $xpath->query("//td[@class='zpic']/img/@src")->item(0))
		{
			$img_src = $el->nodeValue;
			if($img_title = $xpath->query("//td[@class='zpic']/img/@title")->item(0))
				$img_title = iconv('utf-8', 'latin1', $img_title->nodeValue);
			$img = "[img $img_src 300x300 flow right|$img_title]";
		}
		else
			$img = "";

		// Чистим мусор
		foreach(array(
			"//td[@style='background:#EFEDDF; padding:8px 0 12px 16px']/table",
			"//h2",
			"//p[@class='links']",
			"//div[@class='dt']",
		) as $query)
			foreach($xpath->query($query) as $node)
				$node->parentNode->removeChild($node);

//		if($content = $xpath->query("//table[@class='peredovica']")->item(0))
		if($content = $xpath->query("//td[@style='background:#EFEDDF; padding:8px 0 12px 16px']")->item(0))
		{
			$bbcode = iconv('utf-8', 'latin1', trim(bors_lib_bb::from_dom($content, $url, array(
//				'img' => array('bb' => 'img', 'main_attr' => 'src', 'urls' => 'src', 'no_ending' => true, 'lcml0_style' => true, 'append_attrs' => '200x150'),
			))));

			$bbcode = preg_replace("/^\s+$/m", "", $bbcode);
			$bbcode = str_replace('[td]', '', $bbcode);
			$bbcode = str_replace('[/td]', '', $bbcode);
			$bbcode = preg_replace("/\n{2,}/", "\n\n", $bbcode);
			$len = bors_strlen($bbcode);
			$bbcode = bors_close_bbtags(clause_truncate_ceil($bbcode, $limit));
			if($len >= $limit)
				$bbcode .= "\n\n[url={$url}]".ec('… дальше »»»[/url]');

			$description = $bbcode;
		}


		$bbshort = "[b][url={$url}]{$title}[/url][/b]

{$img}{$description}
// ".ec("Подробнее: ").bors_external_feeds_entry::url_host_link($url);

		return compact('tags', 'bbshort');
	}
}
