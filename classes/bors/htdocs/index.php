<?php

class bors_htdocs_index extends bors_page
{
	function title() { return ec('Содержимое каталога ').$this->arg('path'); }

	function body_data()
	{
		$dirs = array();
		$files = array();
		$path = $this->arg('path');

		foreach(glob(bors()->server()->root().$path.'*') as $f)
			if(is_dir($f))
				$dirs[] = array('url' => $path.basename($f).'/', 'base' => basename($f));
			else
				$files[] = array('url' => $path.basename($f), 'base' => basename($f));

		usort($dirs,  function($x, $y) { return strcmp($x['base'], $y['base']);});
		usort($files, function($x, $y) { return strcmp($x['base'], $y['base']);});

		return compact('dirs', 'files') + parent::body_data();
	}

	function config_class()
	{
		return config('auto.dirlist_config');
	}
}
