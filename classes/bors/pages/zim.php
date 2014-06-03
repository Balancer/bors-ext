<?php

// Отработка поддержки: http://forums.balancer.ru/rules/

// Использование:
//		http://www.airbase.ru/vehicles/z/z-19/

class bors_pages_zim extends bors_page
{
	function _host_def() { return $_SERVER['HTTP_HOST']; }

	function parents() { return array(dirname(dirname(bors()->request()->path()))); }

	function can_be_empty() { return false; }

	function is_loaded()
	{
		if($this->__havefc())
			return $this->__lastc();

		$path = bors()->request()->path();
		$this->path = $path;

		if(preg_match('!^(.+)/$!', $path, $m))
			$path = $m[1].'.txt';

		if(!preg_match('/\.txt$/', $path))
			return $this->__setc(false);

		$file = $this->webroot().$path;
		if(!file_exists($file) || !is_file($file))
			return $this->__setc(false);

		$this->parse($file);

		//TODO: Поменять потом на проверку настоящих тегов
		if(preg_match('/(@skip|@hidden)/', $this->source))
			return $this->__setc(false);

		if(preg_match('/(@under_?construction)/', $this->source))
			$this->set_attr('is_under_construction', true);

		return $this->__setc(true);
	}

	function parse($file)
	{
//		echo 'parse '.$file.'<br/>';
//		echo bors_debug::trace();


		$text = str_replace("\r", "", file_get_contents($file));
		if(preg_match("!^(.+?)\n\n(.+)$!s", $text, $m))
			list($this->head_raw, $this->body_raw) = array_slice($m, 1, 2);
		else
			bors_throw("Zim file parse error: can't split header for ".$file);

//		var_dump($this->body_raw);
		if(preg_match("!^\s*={6} (.+?) ={6}\n(.+)$!s", $this->body_raw, $m))
			list($this->title, $this->source) = array_slice($m, 1, 2);
		else
			bors_throw("Zim file parse error: can't get title for ".$file);

		$this->files = [];
		$this->images = [];
		$dir = str_replace('.txt', '', $file);
		foreach(glob($dir.'/*.*') as $fn)
		{
			$rel_fn = str_replace($dir.'/', '', $fn);
			if(preg_match('/\.(jpe?g|png|gif)$/i', $rel_fn))
				$this->images[] = $rel_fn;
//			echo $rel_fn."<br/>\n";
		}
	}

	function source() { return $this->source; }

	function body()
	{
		$text = $this->zim_markup($this->source());
//		print_dd($text);
		return bors_lcml::lcml($text);
	}

	function zim_markup($text)
	{
		$zim_path = $this->path;
		$text = preg_replace("!^(Created.+)\n!", "<i class=\"transgray\"><small>$1</small></i>\n", $text);
		$text = preg_replace("@(?!:)//(.+?[^:])//@s", "<i>$1</i>", $text);
		$text = preg_replace("!\*\*(.+?)\*\*!s", "<b>$1</b>", $text);

		$text = preg_replace("!^====== (.+?) ======$!m", "<h1>$1</h1>\n", $text);
		$text = preg_replace("!^===== (.+?) =====$!m", "<h2>$1</h2>\n", $text);
		$text = preg_replace("!^==== (.+?) ====$!m", "<h3>$1</h3>\n", $text);
		$text = preg_replace("!^=== (.+?) ===$!m", "<h4>$1</h4>\n", $text);
		$text = preg_replace("!^== (.+?) ==$!m", "<h5>$1</h5>\n", $text);
		$text = preg_replace("!^= (.+?) =$!m", "<h6>$1</h6>\n", $text);
		$text = preg_replace_callback("!\[\[(.+?)\|(.+?)\]\]!", function($match) {

			list($foo, $link, $text) = $match;

			// [[http://ria.ru/spravka/20120119/543267582.html|Самолет-ретранслятор Ту-214СР: летно-технические характеристики]]
			if(!preg_match('!^\w+://!', $link))
			{
				if(preg_match('/^\+(.+)$/', $link, $m))
					$link = $m[1];
				else
					$link = '../'.$link;

				if(strpos($link, ':') > 0)
					$link = '/'.str_replace(':', '/', $link);

				if(!preg_match('!/$!', $link))
					$link .= '/';
			}

			return "<a href=\"{$link}\">{$text}</a>";
		}, $text);

		$used_images = [];

		// {{./Z-19-Light-Attack-Helicopter-With-Mast-Mounted-Chinese-ANAPG-78-Longbow-Fire-Control-Radar.jpg?width=640}}
		// {{./Harbin-Z-19-airlines.net-2190503.jpg?href=http://www.airliners.net/photo/China---Air/Harbin-Z-19/2190503/L/&width=300}}
		$text = preg_replace_callback("!\{\{(.+?)\}\}!s", function($match) use($zim_path, &$used_images) {
			$ud = parse_url($match[1]);
			extract($ud);
			$qd = array();
			parse_str(@$query, $qd);
//			var_dump($qd);

			if(!($href = @$qd['href']))
				$href = $path;
//var_dump($href, $qd);
			if(preg_match('!^\./(.+)$!', $path, $m))
			{
				$img	= $this->host() . '/cache-static' .$zim_path . $m[1];

				$used_images[] = $img;

				bors_lib_http::get($img);

				list($iw, $ih) = getimagesize($img);
				$tw = intval(defval($qd, 'width', 640));
				$th = intval(round($tw*$ih/$iw));

				$thumb	= $this->host() . '/cache/cache-static' . $zim_path . "{$tw}x{$th}/" . $m[1];
			}
			else
				bors_throw("Unknown zim image format '$path'");

			return "[img=\"$img\" href=\"$href\" {$tw}x{$th}]";
		}, $text);

//		$text = preg_replace("!(^\* (.+?)$)+!m", "<li>$2</li>", $text);
		$text = preg_replace_callback("!^(\t+)\* !m", function($m) { return str_repeat(' ', strlen($m[1])+1).'* ';}, $text);
//		$text = preg_replace("!\n(?!<ul)([^\n]+)\n<li>!s", "$1\n<ul>\n<li>", $text);

//		$text = preg_replace("/(?:^|\n)([^<].+?[^>])(?:($|\n){2,})/", "<p>$1</p>\n", $text);

//			var_dump($this->images);
		if(count($this->images) > 2)
		{
			$w = 200;
			$h = 200;
		}
		else
		{
			$w = 640;
			$h = 0;
		}

		if($this->images)
		{
			$text .= "<h2>Изображения</h2>\n";
			$bb = "";
//			$bb = "#gallery\n";
			foreach($this->images as $i)
			{
				$img	= $this->host() . '/cache-static' .$zim_path . $i;

				if(in_array($img, $used_images))
					continue;

				bors_lib_http::get($img);
				if(!$h)
				{
					list($iw, $ih) = getimagesize($img);
					$h = intval(round($w*$ih/$iw));
					$thumb	= $this->host() . '/cache/cache-static' . $zim_path . "{$w}x{$h}/" . $i;
				}
				else
				{
					$thumb	= $this->host() . '/cache/cache-static' . $zim_path . "{$w}x{$h}(up,crop)/" . $i;
				}

				$text .= "<a href=\"$img\"><img src=\"$thumb\" width=\"$w\" height=\"$h\"/></a>";
//				$bb .= "[img=\"$img\" {$size} flow noborder]";
//				$bb .= "$img\n";
			}
//			$bb .= "#/gallery";

//			$text .= lcml_bb($bb);

		}

		return $text;
	}
}
