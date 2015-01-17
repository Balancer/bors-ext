<?php

//	http://www.airbase.ru/vehicles/d/dark-sword/
//	http://www.airbase.ru/weapons/a/ai3/news/2012-03-06-ai3-contract/

class bors_pages_markdown extends bors_page
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
			$path = $m[1].'.md';

		if(!preg_match('/\.md$/', $path))
			return $this->__setc(false);

		$file = $this->webroot().$path;
		if(!file_exists($file) || !is_file($file))
			$file = preg_replace('/\.md$/', '/index.md', $file);

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

		// Если в начале файла есть метаданные в блоках «---»:
		if(preg_match("!^---\n(.+?)\n---\n(.+)$!s", trim($text), $m))
		{
			$metadata = bors_data_yaml::parse($m[1]);
			$text = trim($m[2]);
		}
		else
			$metadata = array();

		if(preg_match("!^(.*?)^#\s+(.+?)\s+#$(.+)$!sm", $text, $m))
		{
			$text = trim("{$m[1]}\n{$m[3]}");
			$title = $m[2];
		}

		if(!$title && preg_match("!^(.*?)^#\s+(.+?)$(.+)$!sm", $text, $m))
		{
			$text = trim("{$m[1]}\n{$m[3]}");
			$title = $m[2];
		}

		if(!$title)
			bors_throw("Can't find markdown title for ".$file);

		$this->title = $title;
		$this->source = $text;

		if(!empty($metadata['Date']))
			$this->create_time = strtotime($metadata['Date']);
		else
			$this->create_time = filectime($file);

		if(!empty($metadata['Tags']))
		{
			if(is_string($metadata['Tags']))
				$metadata['Tags'] = preg_split('/\s*,\s*/', $metadata['Tags']);
		}
		else
			$metadata['Tags'] = array();

		$this->keywords_string = join(', ', $metadata['Tags']);

		$this->author_title = defval($metadata, 'Author');
//		~r($metadata, $title, $text);
	}

	function source() { return $this->source; }
	function create_time() { return $this->create_time; }

	function body()
	{
		$html = $this->markup($this->source());
		return bors_lcml::lcml($html);
	}

	function markup($text)
	{
		$html = \Michelf\Markdown::defaultTransform($text);
		return $html;
	}
}
