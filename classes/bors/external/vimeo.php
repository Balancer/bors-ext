<?php

class bors_external_vimeo
{
	static function factory($video_id)
	{
		return new bors_external_vimeo($video_id);
	}

	var $video_id;

	function __construct($video_id)
	{
		$this->video_id = $video_id;
		$info_url = 'http://vimeo.com/api/v2/video/'.$video_id.'.php';
		$data = bors_lib_http::get_cached($info_url, 86400, true);
		$this->info = is_array($data) ? array_pop($data) : NULL;
	}

	function html(&$params = array())
	{
		$width  = defval_ne($params, 'width',  600);
		$height = defval_ne($params, 'height', 450);

		$this->register($params);
		return "<div class=\"round_box shadow8\" style=\"margin: 8px 0 8px 0; width: {$width}px; height: auto;\">"
			."<iframe src=\"http://player.vimeo.com/video/{$this->video_id}\" width=\"{$width}\" height=\"{$height}\" frameborder=\"0\"></iframe><br/>"
			."<small><a href=\"{$this->info['url']}\">{$this->info['title']}</a> @ <a href=\"{$this->info['user_url']}\">{$this->info['user_name']}</a></small>"
			."<div class=\"clear\">&nbsp;</div></div>";
	}

	function register($params)
	{
		if(($self = defval($params, 'self')) && ($self->class_name() == 'balancer_board_post' || $self->class_name() == 'forum_post'))
		{
			if(!bors_find_first('balancer_board_posts_object', array(
					'post_id' => $self->id(),
//					'target_class_id' => class_name_to_id('bors_external_vimeo'),
					'target_class_name' => 'bors_external_vimeo',
					'target_object_id' => $id,
			)))
				object_new_instance('balancer_board_posts_object', array(
					'post_id' => $self->id(),
					'target_class_id' => class_name_to_id('bors_external_vimeo'),
					'target_class_name' => 'bors_external_vimeo',
					'target_object_id' => $id,
					'target_create_time' => $self->create_time(),
					'target_score' => $self->score(),
			));
		}
	}

	static function parse_links($text)
	{
		// http://vimeo.com/34949864
		$text = preg_replace('!^\s*https?://[^/]*vimeo\.com/(\d+)\s*$!mi', '[vimeo]$1[/vimeo]', $text);
		return $text;
	}
}
