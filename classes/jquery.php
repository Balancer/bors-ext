<?php

/**
	Унифицированная работа с jQuery и его плагинами
*/

class jquery
{
	static function load()
	{
		// Со временем поменять местами
		template_jquery();
	}

	static function plugin($name)
	{
		template_jquery_plugin($name);
	}

	static function css($name)
	{
		template_jquery_plugin_css($name);
	}

	static function on_ready($js_code)
	{
		// Если это имя файла, то грузим его контент
		if(preg_match('!^[\w\-\./]+\.js$!', $js_code))
			$js_code = file_get_contents($js_code);

		template_jquery_document_ready($js_code);
	}

	static function use_html()
	{
		$link = '/_bors3rdp/jquery/jquery-'.config('jquery.version').'.min.js';

		return "<!--[[use js=\"$link\"]]-->";
	}

	static function on_ready_html($js_code)
	{
		static $have = array();
		$hash = md5($js_code);

		if(!empty($have[$hash]))
			return '<!--already-->';

//		$have[$hash] = true;

		$html = ""; // jquery::use_html();
		$html .= "<script type=\"text/javascript\" rel=\"test123\"><!--\n\$(document).ready(function() {\n{$js_code}\n});\n--></script>\n";
		return $html.'<!--new123-->';
	}
}
