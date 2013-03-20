<?php

class bors_htdocs_loader extends bors_page
{
	function can_be_empty() { return false; }
	function is_loaded()
	{
		if(!config('auto.dirlist_enable'))
			return false;

		if($this->__havefc())
			return $this->__lastc();

		$page_path = $path = bors()->request()->url_data('path');
		$root = bors()->server()->root();

		// Цикл по относительным ('/themes/17/' -> '/themes/' -> '/') путям
		while($path)
		{
			if(file_exists($ini_file = $root.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.'.htbors.ini'))
				break;

			// Ибо dirname('/') == '/'
			if($path == '/')
				break;

			$path = dirname($path);
		}

		if(!$path || !file_exists($ini_file))
			return $this->__setc(NULL);

		$cfg = parse_ini_file($ini_file, true);
		if(empty($cfg['dirlist']['class']))
			return $this->__setc(NULL);

		$page = bors_load_ex($cfg['dirlist']['class'], bors()->request()->url(), array(
			'ini_path' => $path,
			'ini_cfg'  => $cfg,
			'path' => $page_path,
		));

		return $this->__setc($page);
	}
}
