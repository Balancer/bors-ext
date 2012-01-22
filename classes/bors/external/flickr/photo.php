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

		$sz = $this->medium_size();

		return "<div class=\"round_box\" style=\"width: {$sz['width']}px; height: {$sz['height']};\">
 <a href=\"{$this->flickr_url()}\"><img src=\"{$this->medium_url()}\" /></a><br/>
 <small><a href=\"{$this->flickr_url()}\">{$this->flickr_title()}</a> @ <a href=\"{$this->owner_url()}\">{$this->owner_title()}</a></small>
</div>";
	}

	function owner_title() { return $this->info['photo']['owner']['username']; }
	function owner_url()
	{
		$ui = $this->flickr->people_getInfo($this->info['photo']['owner']['nsid']);
		return $ui['photosurl'];
	}

	function sizes() { return $this->flickr->photos_getSizes($this->photo_id); }

	function medium_size()
	{
		$ss = $this->sizes();
		return $ss[4];
	}
}
