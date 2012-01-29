<?php

/**
	Оформление разного рода ссылок на файлы по их расширению
*/

class lcml_parser_filetypes extends bors_lcml_parser
{
	function html($text)
	{
		// Обрабатываем только ссылки на файлы с расширением
		if(!preg_match_all('!^\s*(https?://\S+\.(\w+))\s*$!im', $text, $matches, PREG_SET_ORDER))
			return $text;
/*
array
  0 => 
    array
      0 => string 'http://www.boskalis.com/fileadmin/user_upload/Afbeeldingen/Perskamer/Persberichten/Update_Costa_Concordia/Press_Briefing_Oil_Removal_280112.pdf' (length=144)
      1 => string 'http://www.boskalis.com/fileadmin/user_upload/Afbeeldingen/Perskamer/Persberichten/Update_Costa_Concordia/Press_Briefing_Oil_Removal_280112.pdf' (length=143)
      2 => string 'pdf' (length=3)
*/
		foreach($matches as $match)
		{
			$ext = $match[2];
			class_include($cn = "lcml_tag_pair_file_{$ext}");
			if(!class_exists($cn))
				continue;

			$text = preg_replace('!^\s*('.preg_quote($match[1], '!').')\s*$!ime', "lcml('[file_{$ext}]$1[/file_{$ext}]');", $text);
		}

		return $text;
	}

	function text($text)
	{
		return $this->html($text);
	}
}
