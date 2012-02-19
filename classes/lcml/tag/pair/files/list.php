<?php

class lcml_tag_pair_files_list extends bors_lcml_tag_pair
{
	function html($list, &$params = array())
	{
		bors_page::use_css('/_bors-ext/css/file-types.css');

		$html = array();
		$last_dir = NULL;
		foreach(explode("\n", $list) as $file)
		{
			if(!($file = trim($file)))
				continue;

//			var_dump($file);
			if(preg_match('!^[\w/]+/$!', $file))
			{
				$last_dir = $file;
				continue;
			}

			if(preg_match('!^([\w/\-\.]+)\s+(.+?)$!', $file, $m))
			{
				$file = $m[1];
				$description = $m[2];
			}
			else
				$description = basename($file);

			if($file[0] != '/')
				$file = $last_dir.$file;

			$type = bors_load('bors_file_type', bors()->server()->document_root().$file);
			$html[] = "<li class=\"{$type->css_class()}\"><a href=\"$file\">".htmlspecialchars($description)."</a></li>";
		}

		return "<ul class=\"files-list\">\n".join("\n", $html)."\n</ul>\n";
	}
}
