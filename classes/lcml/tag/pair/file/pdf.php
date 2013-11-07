<?php

class lcml_tag_pair_file_pdf extends bors_lcml_tag_pair
{
	function html($url, &$params = array())
	{
		//TODO: не забыть убрать после отладки!
//		if(!config('is_developer'))
		if(config('lcml.parse_lite', true))
			return lcml_tag_pair_file_pdf::parse_lite($url, $params);

		if(config('lcml.postpone_full'))
			return lcml_tag_pair_file_pdf::parse_full($url, $params);

//		if(config('is_developer'))
//			return lcml_tag_pair_file_pdf::parse_full($url, $params);

		if($target_uri = object_property($params['self'], 'internal_uri_ascii'))
		{
			bors_tasks_gearman::add('lcml_postpone_worker', array(
				'target' => $target_uri,
			));
//			echo 'task started';
		}

		$params['show_spinner'] = true;
		return lcml_tag_pair_file_pdf::parse_fast($url, $params);
	}

	function parse_lite($url, $params)
	{
		return "<div class=\"bors_file_pdf\"><a href=\"{$url}\">".urldecode(basename($url))."</a></div>";
	}

	function parse_fast($url, $params)
	{
		$file_object = bors_find_first('airbase_web_file', array('web_url' => $url));
		if($file_object && $file_object->title())
		{
			$file = $file_object->file();
			$full_file_name = "/data/files/wget-cache/$file";

			$cover = $full_file_name.'.cover.jpg';
			$cover_url = "http://balancer.ru/_bal/webcache/".$file.'.cover.jpg';
			if(file_exists($cover))
				return self::parse_full($url, $params);
		}

		return "<div".(@$params['show_spinner'] ? ' class="spinner post_reload"' : '')."><a href=\"{$url}\">".basename($url)."</a></div>";
	}

	function parse_full($url, $params)
	{
		$file_object = bors_find_first('airbase_web_file', array('web_url' => $url));
		if(!$file_object)
		{
			system("/data/files/wget-cache/w.sh ".escapeshellarg($url));
			$file_object = bors_find_first('airbase_web_file', array('web_url' => $url));
		}

		if(!$file_object)
		{
			debug_hidden_log('__error_lcml_postpone', "Can't parse full for $url");
			$params['show_spinner'] = false;
			return self::parse_fast($url, $params);
		}

		$file = $file_object->file();
		$full_file_name = "/data/files/wget-cache/$file";
		$file_cache_url = "http://balancer.ru/_bal/webcache/$file";

		$cover = $full_file_name.'.cover.jpg';
		$cover_url = "http://balancer.ru/_bal/webcache/".$file.'.cover.jpg';
		if(!file_exists($cover))
		{
			system("convert ".escapeshellarg("{$full_file_name}[0]").' '.escapeshellarg($cover));
			chmod($cover, 0666);

		}

		$title = $file_object->title();
		if(empty($title))
		{
			require_once '/usr/share/php/Zend/Pdf.php';
			$pdf = Zend_Pdf::load($full_file_name);
			$title = iconv('utf-8', 'utf-8//ignore', htmlspecialchars(trim($pdf->properties['Title'])));
			if(!$title)
				$title = basename($url);

			$file_object->set_title($title);
		}

		//TODO: Взять увеличение картинки с http://jmar.github.com/jquery-hoverZoom/
//		var_dump("[round_box][img=$cover_url 100x100 left flow nohref][h][url={$url}]{$title}[/url][/h][/round_box]");
		return lcml("[round_box][img=$cover_url 200x100 left flow ajax='hoverZoom']"
			."[b]".(bors_file_type::icon('pdf')->html())." [url={$url}]{$title}[/url][/b][br]"
			."[small]".ec('Файл в кеше: ')."[url={$file_cache_url}] ".basename($file)."[/url][br]"
			."Размер: "	.smart_size($file_object->size())
			."[/small]"
			."[/round_box]");
	}
}
