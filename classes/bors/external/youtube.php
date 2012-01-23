<?php

class bors_external_youtube extends bors_object
{
	var $video_id;

	function id() { return $this->video_id; }

	static function factory($video_id)
	{
		return new bors_external_youtube($video_id);
	}

	function __construct($video_id)
	{
		$video_id = self::id_prepare($video_id);
		$this->video_id = $video_id;
	}

	static function id_prepare($id)
	{
		if(preg_match('/youtube/', $id))
		{
			bors_function_include('url/parse');
			$id = bors_url_parse($id, 'query', 'v');
		}

		return $id;
	}

	static function url2html($url)
	{
		$youtube = self::factory($url);
		return $youtube->html();
	}

	static function parse_links($text)
	{
//		$text = preg_replace('!<a href="https?://[^/]+flickr\.com/photos/\w+@\w+/(\d+)/"[^>]+><img src="[^"]+static.flickr.com/[^"]+\.jpg"[^>]+/></a>!is', '[flickr]$1[/flickr]', $text);

		// [url=http://www.youtube.com/watch?v=a8C1iU-xAog]http://www.youtube.com/watch?v=a8C1iU-xAog[/url]
		// [url=http://www.youtube.com/watch?v=JkpO2BliOVg]http://www.youtube.com/watch?v=JkpO2BliOVg[/url]
		$text = preg_replace('!\s*\[url=(http://(www\.)?youtube\.com/watch\?v=[\w\-]+?)\]\1\[/url\]\s*!', "\n$1\n", $text);
		// [url=http://youtube.com/watch?v=cF_rMpiwzQA&search=loituma]http://youtube.com/watch?v=cF_rMpiwzQA&search=loituma[/url]
		$text = preg_replace('!\s*\[url=(http://(www\.)?youtube\.com/watch\?v=[\w\-]+[^\]]+?)\]\1\[/url\]\s*!', "\n$1\n", $text);

		// http://www.youtube.com/watch?v=X76LmiHVFsM&feature=player_embedded
		// http://www.youtube.com/watch?v=TXxcR3qgyYQ&playnext=1&list=PL21AA194D7FBBA2D9
		// https://www.youtube.com/watch?v=21El16OPZoc
		// http://www.youtube.com/watch?feature=player_embedded&v=zZPNaMDD-A8
		$text = preg_replace('!^\s*(https?://[^/]*youtube\.\w+/watch\S+)\s*$!mie', "bors_external_youtube::url2bb('$1');", $text);
		return $text;
	}

	// Трансляция ссылки на YouTube ролик в [youtube]<video-id>[/youtube]
	static function url2bb($url)
	{
//		echo "===".$url."===\n";
		$url = bors_entity_decode($url);
		bors_function_include('url/parse');
		$video_id = bors_url_parse($url, 'query', 'v');
		return "[youtube]{$video_id}[/youtube]";
	}

	function title()
	{
		if($this->__havefc())
			return $this->__lastc();

		$gdata_url = "http://gdata.youtube.com/feeds/api/videos/".$this->id();
		$html = bors_lib_http::get_cached($gdata_url, 86400*7);
		$doc = new DOMDocument;
//		echo "\n=================\n$html\n=================\n";
		@$doc->loadHTML($html);
		return $this->__setc($doc->getElementsByTagName("title")->item(0)->nodeValue);
	}

	function html(&$params=array())
	{
		$width  = @$params['width']  ? $params['width']  : '640';
		$height = @$params['height'] ? $params['height'] : '390';

		$this->register($params);

		return "<div class=\"rs_box\" style=\"width: {$width}px;\">"
			."<iframe width=\"{$width}\" height=\"{$height}\" src=\"http://www.youtube.com/embed/{$this->id()}\""
			." frameborder=\"0\" allowfullscreen></iframe><br/>"
			."<small class=\"inbox\"><a href=\"http://www.youtube.com/watch/?v={$this->id()}\">{$this->title()}</a></small></div>";
	}

	function text(&$params=array())
	{
		$this->register($params);
		return $this->title()."\nhttp://www.youtube.com/watch?v=".$this->id()."\n";
	}

	function register($params)
	{
		if(!($self = defval($params, 'self')))
			return;

		if($self->class_name() != 'balancer_board_post' && $self->class_name() != 'forum_post')
			return;

		if(bors_find_first('balancer_board_posts_object', array(
			'post_id' => $self->id(),
			'target_class_name' => 'bors_external_youtube',
			'target_object_id' => $this->id(),
		)))
			return;

		bors_new('balancer_board_posts_object', array(
			'post_id' => $self->id(),
			'target_class_id' => class_name_to_id('bors_external_youtube'),
			'target_class_name' => 'bors_external_youtube',
			'target_object_id' => $this->id(),
			'target_create_time' => $self->create_time(),
			'target_score' => $self->score(),
		));
	}
}
