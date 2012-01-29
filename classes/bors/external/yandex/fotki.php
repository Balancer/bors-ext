<?php

class bors_external_yandex_fotki
{
	static function factory($photo_id)
	{
		return new bors_external_yandex_fotki($photo_id);
	}

	var $photo_id;
	var $user_id;

	function __construct($id)
	{
		list($this->user_id, $this->photo_id) = explode('/', $id);
	}

	static function parse_links($text)
	{
		// <a href="http://fotki.yandex.ru/users/balancer73/view/404156/"><img src="http://img-fotki.yandex.ru/get/4702/22492983.10/0_62abc_3448e98c_M.jpg" width="203" height="132" title="Юпитер со спутниками над Москвой" alt="Юпитер со спутниками над Москвой" border="0"/></a><br/>«<a href="http://fotki.yandex.ru/users/balancer73/view/404156/">Юпитер со спутниками над Москвой</a>» на <a href="http://fotki.yandex.ru/">Яндекс.Фотках</a>
		// http://img-fotki.yandex.ru/get/4702/22492983.10/0_62abc_3448e98c_M.jpg

		// [url=http://fotki.yandex.ru/users/balancer73/view/404156/][img]http://img-fotki.yandex.ru/get/4702/22492983.10/0_62abc_3448e98c_M.jpg[/img][/url]
		$text = preg_replace('!\[url=http://fotki\.yandex\.ru/users/(\w+)/view/(\d+)/\]\[img\]http://[^\[]+?\[/img\]\[/url\]!', "[yandex_fotki]$1/$2[/yandex_fotki]", $text);

		// http://fotki.yandex.ru/users/balancer73/view/404156/?page=0
		$text = preg_replace('!^\s*http://fotki\.yandex\.ru/users/(\w+)/view/(\d+)/\?page=\d+\s*$!m', "[yandex_fotki]$1/$2[/yandex_fotki]", $text);

		// http://fotki.yandex.ru/users/balancer73/view/404156/
		$text = preg_replace('!^\s*http://fotki\.yandex\.ru/users/(\w+)/view/(\d+)/\s*$!m', "[yandex_fotki]$1/$2[/yandex_fotki]", $text);

		return $text;
	}

	function html()
	{
//		echo "http://api-fotki.yandex.ru/api/users/{$this->user_id}/photo/{$this->photo_id}/";
		$info = json_decode(bors_lib_http::get("http://api-fotki.yandex.ru/api/users/{$this->user_id}/photo/{$this->photo_id}/?format=json", true), true);
//		var_dump($info);
//		exit();
		// <a href='/images/zoomengine/bigimage00.jpg' class = 'cloud-zoom' id='zoom1' rel="adjustX: 10, adjustY:-4">
		//	<img src="/images/zoomengine/smallimage.jpg" alt='' title="Optional title display" />
		// </a>

		$orig = $info['img']['orig'];
		$xl   = @$info['img']['L']; // L=500, XL=800

		if(empty($xl))
			$xl = $orig;

		$title = $info['title'];

		return "<div class=\"rs_box mtop8\" style=\"width: {$xl['width']}px;\">"
			."<a href=\"{$orig['href']}\" class=\"cloud-zoom\" id=\"zoom-".rand()."\" rel=\"position:'inside'\">"
			."<img src=\"{$xl['href']}\" alt=\"[image]\" title=\"".htmlspecialchars($title)."\" width=\"{$xl['width']}\" height=\"{$xl['height']}\" />"
			."</a><br/>"
			."<small class=\"inbox\"><a href=\"{$info['links']['self']}\">{$title}</a> @&nbsp;<a href=\"{$info['links']['album']}\">Яндекс.Фотки</a></small>"
			."</div>";
	}
}
