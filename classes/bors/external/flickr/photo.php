<?php

class bors_external_flickr_photo
{
	static function factory($photo_id)
	{
		return new bors_external_flickr_photo($photo_id);
	}

	var $photo_id;
	var $flickr;
	var $photo;
	var $info;
	function __construct($photo_id)
	{
		$this->photo_id = $photo_id;
		require_once(config('phpFlickr.path')."/phpFlickr.php");
		$this->flickr = new phpFlickr(config('phpFlickr.api_key'));
		$cache_dir = config('cache_dir').'/phpFlickr';
		mkpath($cache_dir);
		$this->flickr->enableCache("fs", $cache_dir);
		$this->flickr->cache_dir = $cache_dir;

		$this->info = $this->flickr->photos_getInfo($photo_id);
		require_once('inc/debug.php');
//		var_dump($this->info);
		$this->photo = $this->info['photo'];
	}

	function flickr_url() { return $this->info['photo']['urls']['url'][0]['_content']; }
	function medium_url() { return $this->flickr->buildPhotoURL($this->photo, 'medium_640'); }
	function flickr_title() { return $this->photo['title']; }

	function html()
	{
		if(!$this->info)
			return ec("<div class=\"red_box\">Данное фото на Flickr фото не найдено или доступ к нему запрещён</div>");

		$s640	= $this->find_size(640);
		$s1024	= $this->find_size(1024);
		$s0	= $this->find_size(0);

		return "<div class=\"round_box shadow8\" style=\"margin: 8px 0 8px 0; width: {$s640['width']}px; height: {$s640['height']};\">
 <a href=\"{$s1024['source']}\" class=\"cloud-zoom thumbnailed-image-link\" rel=\"gallery\"><img src=\"{$this->medium_url()}\" /></a><br/>
 <small><a href=\"{$this->flickr_url()}\" target=\"_blank\">{$this->flickr_title()}</a> @ <a href=\"{$this->owner_url()}\" target=\"_blank\">{$this->owner_title()}</a>; [<a href=\"{$s0['url']}\" target=\"_blank\">полный размер: {$s0['width']}x{$s0['height']}</a>]</small>
</div>";
	}

	function owner_title() { return $this->info['photo']['owner']['username']; }
	function owner_url()
	{
		$ui = $this->flickr->people_getInfo($this->info['photo']['owner']['nsid']);
		return $ui['photosurl'];
	}

	function sizes() { return $this->flickr->photos_getSizes($this->photo_id); }

	function find_size($size)
	{
		$ss = $this->sizes();

		usort($ss, function($a, $b) { return $a['width'] - $b['width']; });

		$max_s = array('width' => 0);

		foreach($ss as $s)
		{
			if($size && $s['width'] >= $size)
				return $s;

			if($s['width'] > $max_s['width'])
				$max_s = $s;
		}

		return $max_s;
	}
}
