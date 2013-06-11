<?php

class bors_imagick extends bors_object
{
	var $actions_path	= array();
	var $actions		= array();
	var $image			= NULL;

	// /ci/325/325534.jpg
	// /ci/325/325534,crop=200x200+100,geometry=64x64.jpg

	static function id_prepare($id)
	{
//		var_dump($id);
		$self_class_name = get_called_class();
		$magick = new $self_class_name(NULL);

		if(is_numeric($id))
		{
			$magick->image = bors_load($magick->image_class(), $id);
			return $magick;
		}

		$parts = explode(',', $id);
		$magick->image_id  = array_shift($parts);
		$magick->file_name = array_pop($parts);
//		var_dump($magick->image_id, $magick->file_name);
		$magick->image = bors_load($magick->image_class(), $magick->image_id);
		foreach($parts as $action)
		{
			list($action, $params) = explode('=', $action);
			$magick->add_action($action, $params);
		}

		return $magick;
	}

	function add_action($action, $params)
	{
		$this->actions_path[] = $action.'='.$params;
		$this->actions[] = array($action, $params);
	}

	function auto($geometry)
	{
		$this->add_action('auto', $geometry);
		return $this;
	}

	function crop($geometry)
	{
		$this->add_action('crop', $geometry);
		return $this;
	}

	function fill($geometry)
	{
		$this->add_action('fill', $geometry);
		return $this;
	}

	function resize($geometry)
	{
		$this->add_action('resize', $geometry);
		return $this;
	}

	function face_fill($geometry)
	{
		$this->add_action('face-fill', $geometry);
		return $this;
	}

	function base_name() { return preg_replace('/^'.$this->image->id().'-/', '', $this->image->file_name()); }

	function file_name()
	{
		$parts = array($this->image->id());
		$parts = array_merge($parts, $this->actions_path);
		return join(',', $parts).','.$this->base_name();
	}

	function url()
	{
		return $this->base_url().'/'.$this->file_name();
	}

	function do_action(&$img, $action, $geometry)
	{
		$w = $h = $dx = $dy = NULL;
		if(preg_match('/^(\d+)x(\d+)([\+\-]\d+)([\+\-]\d+)$/', $geometry, $m))
			list($foo, $w, $h, $dx, $dy) = $m;
		elseif(preg_match('/^(\d+)x(\d+)$/', $geometry, $m))
			list($foo, $w, $h) = $m;

		$iw = $img->getImageWidth();
		$ih = $img->getImageHeight();

		switch($action)
		{
			case 'auto':
				$img->thumbnailImage($w, $h, false);
				break;
			case 'crop':
				$img->cropImage($w, $h, $dx, $dy);
				break;
			// Только до ресайзов! Работает лишь с исходным размером!
			case 'face-fill':
				// Сбрасываем картинку в исходное состояние
				$img = new Imagick($this->image->file_name_with_path());

				$face = $this->image->face_area();
				if(is_array($face))
				{
					$fw = $face['w'];
					$fh = $face['h'];
					$fx = $face['x'];
					$fy = $face['y'];
				}
				else
				{
					$fw = $iw;
					$fh = $ih;
					$fx = 0;
					$fy = 0;
				}

				if($fw < $w && $fh < $h)
				{
					$fcx = $fx+$fw/2;
					$fcy = $fy+$fh/2;
					$fx = max(0, $fcx - $w/2);
					$fy = max(0, $fcy - $h/2);
					$fw = $w;
					$fh = $h;
				}

				if($w/$h > $fw/$fh)
				{
					// Если кроп шире, чем лицо
					$th = $fh;
					$tw = $w/$h * $fh;
				}
				else
				{
					$tw = $fw;
					$th = $h/$w * $fw;
				}

//				var_dump(array('th', $tw, $th));

				$xl = round(max($fx - $tw/2, 0));
				$xr = round(min($xl + $tw-1, $iw-1));
				$yt = round(max($fy - $th/2, 0));
				$yb = round(min($yt + $th-1, $ih-1));

//				var_dump(array('crop', $xr-$xl+1, $yb-$yt+1, $xl, $yt));

				$img->cropImage($xr-$xl+1, $yb-$yt+1, $xl, $yt);
				$img->cropThumbnailImage($w, $h);
				break;
			case 'fill':
/*
				if($w/$h < $iw/$ih)
				{
					// Если кроп шире, чем оригинал
					$th = round($h);
					$tw = round($iw/$ih * $th);
					$dy = 0;
					if(is_null($dx))
						$dx = round(($tw - $w)/2);
				}
				else
				{
					$tw = round($w);
					$th = round($ih/$iw * $tw);
					$dx = 0;
					if(is_null($dy))
						$dy = round(($th - $h)/2);
				}
*/
//				var_dump("$iw x $ih", "$w x $h", "$tw x $th", $dx, $dy); exit();
				// Сперва отресайзим до вписывания в нужный размер
//				$img->adaptiveResizeImage($tw, $th, true);
				$img->cropThumbnailImage($w, $h);
				// А потом обрежем под него
//				$img->chopImage($w, $h, $dx, $dy);
				break;
			case 'resize':
				$img->adaptiveResizeImage($w, $h, true);
				break;
			default:
				debug_hidden_log('imagick', "Unknown action $action for $geometry");
		}
	}

	function content()
	{
		$base_name = $this->base_name();
		$source_image = $this->image->file_name_with_path();

		$img = NULL;

		$append_parts = array($this->image_id);

		if(!file_exists($f = $this->base_dir().'/'.$this->image_id.','.$base_name))
		{
			$img = new Imagick($source_image);
			mkpath(dirname($f));
//			echo 'write '.$f."<br/>\n";
			$img->writeImage($f);
		}

		$parent_file = $f;
		foreach($this->actions as $x)
		{
			$append_parts[] = $x[0].'='.$x[1];
//			echo "Check ".print_r($x, true)."<br/>\n";
			if(!file_exists($f = $this->base_dir().'/'.join(',', $append_parts).','.$base_name))
			{
				if(!$img)
					$img = new Imagick($parent_file);

				$this->do_action($img, $x[0], $x[1]);

				mkpath(dirname($f));
//				echo 'write '.$f."<br/>\n";
				$img->writeImage($f);
			}

			$parent_file = $f;
		}

//		var_dump('content', $base_name, 'f='.$f, $source_image);
//		var_dump($img->displayImage());
		return go($this->url());
	}

	function alt_or_description()
	{
		return $this->image->alt_or_description();
	}

	var $image_size = false;
	function imagesize($type)
	{
		if(!$this->image_size)
			$this->image_size = getimagesize($this->base_dir().'/'.$this->file_name());

		return @$this->image_size[$type];
	}

	function width()  { return $this->imagesize(0); }
	function height() { return $this->imagesize(1); }

	function wxh()
	{
		$w = $this->width() ? "width=\"{$this->width()}\"" : "";
		$h = $this->height() ? "height=\"{$this->height()}\"" : "";

		return  "{$h} {$w} alt=\"[image]\" title=\"".htmlspecialchars($this->alt_or_description())."\"";
	}

	function html($args = array()) { return $this->html_code(@$args['append']); }
	function html_code($append = "")
	{
		return "<img src=\"{$this->url()}\" {$this->wxh()} $append />";
	}

	function thumbnail($geometry)
	{
		if(preg_match('/^(\d+x\d+)\(/', $geometry, $m))
			$geometry = $m[1];
		if(preg_match('/^(\d+)x$/', $geometry, $m))
			return $this->auto("{$m[1]}x0");
		if(preg_match('/^x(\d+)$/', $geometry, $m))
			return $this->auto("0x{$m[1]}");

		return $this->fill($geometry);
	}
}
