<?php

// Простое проксирование на статику в webroot

// Использование:
//		http://www.airbase.ru/vehicles/z/z-19/Harbin-Z-19-airlines.net-2190503.jpg

class bors_files_webroot extends bors_page
{
	function can_be_empty() { return false; }

	function is_loaded()
	{
		$path = str_replace('/cache-static/', '/', bors()->request()->path());
		$this->path = $path;

		$file = $this->webroot().$path;
		if(!file_exists($file) || !is_file($file))
			return false;

		$this->file = $file;

		return true;
	}

	function direct_content()
	{
		$cached_file = $this->cache_static_dir().$this->path;
		mkpath(dirname($cached_file));
		copy($this->file, $cached_file);

		$finfo = new finfo(FILEINFO_MIME);
		$mime = $finfo->file($this->file);

		header('content-type: ' . $mime);
		readfile($this->file);

		return true;
	}
}
