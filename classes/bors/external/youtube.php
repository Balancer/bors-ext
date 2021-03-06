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
			bors_function_include('url/bors_url_parse');
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

		// <iframe width="560" height="315" src="http://www.youtube.com/embed/ROrpKx3aIjA" frameborder="0" allowfullscreen></iframe>
		// http://www.balancer.ru/g/p3124994
		// <iframe width="420" height="315" src="//www.youtube.com/embed/NeHgI_GHE1c" frameborder="0" allowfullscreen></iframe>
		// http://www.balancer.ru/g/p3205356
		$text = preg_replace_callback('!<iframe[^>]+width="\d+"[^>]height="\d+"[^>]src="(http://|//)www\.youtube\.com/embed/([^"]+)"[^>]+></iframe>!i', function($m) { return bors_external_youtube::id2bb($m[2]);}, $text);

		$text = preg_replace_callback('!^\s*https?://youtu\.be/([\w\-]+)#t=(\w+)\s*$!mi', function($m) { return bors_external_youtube::id2bb($m[1], $m[2]);}, $text);
		$text = preg_replace_callback('!^\s*https?://youtu\.be/([\w\-]+)\?t=(\w+)\s*$!mi', function($m) { return bors_external_youtube::id2bb($m[1], $m[2]);}, $text);
		$text = preg_replace_callback('!^\s*https?://youtu\.be/([\w\-]+)/?\s*$!mi', function($m) { return bors_external_youtube::id2bb($m[1]);}, $text);

		// <iframe width="480" height="360" src="https://www.youtube.com/embed/uVEWtpyrpDM?rel=0&controls=0" frameborder="0" allowfullscreen></iframe>
		// http://www.balancer.ru/g/p3733064
		$text = preg_replace_callback('!<iframe [^>]+src="https://www.youtube.com/embed/([\w\-]+).+?</iframe>!i', function($m) { return bors_external_youtube::id2bb($m[1]);}, $text);

		// [url=http://www.youtube.com/watch?v=a8C1iU-xAog]http://www.youtube.com/watch?v=a8C1iU-xAog[/url]
		// [url=http://www.youtube.com/watch?v=JkpO2BliOVg]http://www.youtube.com/watch?v=JkpO2BliOVg[/url]
		$text = preg_replace('!\s*\[url=(http://(www\.)?youtube\.com/watch\?v=[\w\-]+?)\]\1\[/url\]\s*!', "\n$1\n", $text);
		// [url=http://youtube.com/watch?v=cF_rMpiwzQA&search=loituma]http://youtube.com/watch?v=cF_rMpiwzQA&search=loituma[/url]
		$text = preg_replace('!\s*\[url=(http://(www\.)?youtube\.com/watch\?v=[\w\-]+[^\]]+?)\]\1\[/url\]\s*!', "\n$1\n", $text);

		// http://www.youtube.com/watch?v=zJMVZXLFaRU#t=2085s via http://www.balancer.ru/g/p3030014
		$text = preg_replace_callback('!^\s*(https?://[^/]*youtube\.\w+/watch[^\[\s]+)#t=(\w+)\s*$!mi', function($m) { return bors_external_youtube::url2bb($m[1], $m[2]);}, $text);

		// http://www.youtube.com/watch?v=X76LmiHVFsM&feature=player_embedded
		// http://www.youtube.com/watch?v=TXxcR3qgyYQ&playnext=1&list=PL21AA194D7FBBA2D9
		// https://www.youtube.com/watch?v=21El16OPZoc
		// http://www.youtube.com/watch?feature=player_embedded&v=zZPNaMDD-A8
		$text = preg_replace_callback('!^\s*(https?://[^/]*youtube\.\w+/watch[^\[\s]+)\s*$!mi', function($m) { return bors_external_youtube::url2bb($m[1]);}, $text);
//TODO: разобраться с http://balancer.ru/g/p2706190
//		// http://www.youtube.com/v/C2zdNzmBanQ?version=3&hl=ru_RU
//		$text = preg_replace('!^\s*(https?://[^/]*youtube\.\w+/v/([^\s&\?]+))\s*$!mi', "[youtube]$2[/youtube]", $text);
		$text = preg_replace('!^\s*\[html_iframe [^\]]+ src="https?://[^/]+youtube\.\w+/embed/([^"]+)"[^\]]+\]\[/html_iframe\]\s*$!mi', "[youtube]$1[/youtube]", $text);

		// Пример: http://www.balancer.ru/g/p2933240
		// <object width="420" height="315"><param name="movie" value="http://www.youtube.com/v/hqXeq4olSdg?version=3&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/hqXeq4olSdg?version=3&amp;hl=en_GB" type="application/x-shockwave-flash" width="420" height="315" allowscriptaccess="always" allowfullscreen="true"></embed></object>
		$text = preg_replace_callback('!<object width="\d+" height="\d+"><param name="movie" value="(https?://www.youtube[^"]+)"></param>.+?</embed></object>!s',
			function($m) { return bors_external_youtube::url2bb($m[1]);}, $text);

		// http://www.youtube.com/embed/hNUeSUXOc-w?wmode=opaque — http://www.balancer.ru/g/p3015686
		$text = preg_replace_callback('!^\s*https?://(www\.)?youtube\.com/embed/([\w\-]+)\?wmode=opaque\s*$!mi',
			function($m) { return bors_external_youtube::id2bb($m[2]);}, $text);

		return $text;
	}

	// Трансляция ссылки на YouTube ролик в [youtube]<video-id>[/youtube]
	static function url2bb($url, $time_start = 0)
	{
//		echo "===".$url."===\n";
		bors_use('url/bors_url_parse');
		bors_use('html/bors_entity_decode');

		if(strpos($url, '%') !== false)
			$url = urldecode($url);

		if(strpos($url, '&') !== false)
			$url = bors_entity_decode($url);

		// Пример: http://www.balancer.ru/g/p2933240
		if(preg_match('!http://www.youtube.com/v/(.+?)\?version=!', $url, $m))
			$video_id = $m[1];
		else
		{
			$video_id = bors_url_parse($url, 'query', 'v');
		}

		if(!$time_start)
			$time_start = bors_url_parse($url, 'query', 't');

		return "[youtube".($time_start ? " start=\"$time_start\"" : '')."]{$video_id}[/youtube]";
	}

	// Трансляция готовых id/time в [youtube start="..."]<video-id>[/youtube]
	static function id2bb($video_id, $time_start = 0)
	{
		return "[youtube".($time_start ? " start=\"$time_start\"" : '')."]{$video_id}[/youtube]";
	}

	function title()
	{
		if($this->__havefc())
			return $this->__lastc();

		$info = $this->info();
		$title = @$info['items'][0]['snippet']['title'];

		if(!$title)
			$title = $this->id();

		return $this->__setc($title);
	}

	function description()
	{
		if($this->__havefc())
			return $this->__lastc();

		$info = $this->info();
		$desc  = clause_truncate_ceil(str_replace("\n", " ", @$info['items'][0]['snippet']['description']), 300);

		return $this->__setc($desc);
	}

	function info()
	{
		if($this->__havefc())
			return $this->__lastc();

		$gdata_url = 'https://www.googleapis.com/youtube/v3/videos?id='.$this->id()
			.'&key='.config('google.youtube_api3_key')
			.'&part=snippet,contentDetails,statistics';

		$info = json_decode(bors_lib_http::get_cached($gdata_url, 86400*7), true);

		return $this->__setc($info);
	}

	function html(&$params=array())
	{
		$width  = empty($params['width']) ? 640 : $params['width'];
		$height = empty($params['height'])? 390 : $params['height'];

		$this->register($params);

		$flv_url = "http://www.youtube.com/embed/{$this->id()}";
		$page_url = "http://www.youtube.com/watch/?v={$this->id()}";
		if($start = defval($params, 'start'))
		{
			if(preg_match('/(\d+)m(\d+)s/', $start, $m))
				$start = 60*$m[1] + $m[2];
			elseif(preg_match('/(\d+)m/', $start, $m))
				$start = 60*$m[1];

			$flv_url .= '?start='.preg_replace('/^(\d+)s$/', '$1', $start).'#t='.$start;
			$page_url .= '#t='.$start;
		}

		return "<div class=\"rs_box\" style=\"width: {$width}px;\">"
			."<iframe width=\"{$width}\" height=\"{$height}\" src=\"{$flv_url}\""
			." frameborder=\"0\" allowfullscreen></iframe><br/>"
			."<small class=\"inbox\"><b><a href=\"{$page_url}\">{$this->title()}</a></b>"
			.(($d = $this->description()) ? "<br/>$d" : "")
			."</small></div>";
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

	function image_url()
	{
		return "http://img.youtube.com/vi/{$this->id()}/hqdefault.jpg";
	}
}
