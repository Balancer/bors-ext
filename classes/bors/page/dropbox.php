<?php

/**
	Класс автозагрузки hts/etc статических файлов из внешнего синхронизируемого каталога
*/

class bors_page_dropbox extends bors_page
{
	function can_be_empty() { return false; }
	function is_loaded() { return (bool) $this->object(); }

	function title() { return $this->object()->title(); }
	function body() { return $this->object()->body(); }

	function request_url()
	{
		$uri = $this->id();
		if($uri)
			return $uri;

		return bors()->request()->path();
	}

	function object()
	{
		if($this->__havefc())
			return $this->__lastc();

		$webroot = $this->webroot();
		$relative_path = $this->request_url();
		$abs_path = $webroot . $relative_path;

		list($type, $file) = $this->_find_file($abs_path);
		if(!$type || !$file)
			return $this->__setc(false);

		$page = bors_load($type, $file);

		return $this->__setc($page);
	}

	private function _find_file($abs_path)
	{
		if(file_exists($file = preg_replace('!^(.+)/$!', '$1.hts', $abs_path)))
			return array('bors_page_fs_htsu', $file);

		if(file_exists($file = preg_replace('!^(.+)/$!', '$1/index.hts', $abs_path)))
			return array('bors_page_fs_htsu', $file);

		return array(false, NULL);
	}
}
