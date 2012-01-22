<?php

class bors_external_flickr_photo
{
	static function factory($photo_id)
	{
		return new bors_external_flickr_photo($photo_id);
	}

	var $flickr;
	var $photo;
	var $info;
	function __construct($photo_id)
	{
//		$photo_id = '5555766100';
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

		return "<div class=\"round_box\">
 <a href=\"{$this->flickr_url()}\"><img src=\"{$this->medium_url()}\" /></a><br/>
 <small><a href=\"{$this->flickr_url()}\">{$this->flickr_title()}</a></small>
</div>";
	}
}
