<?php

/**
	Унифицированная работа с jQuery и его плагинами
*/

class jquery
{
	static function load($link = NULL)
	{
		static $is_loaded = false;
		if($is_loaded)
			return;

		if(!$link)
		{
			if(config('jquery.use_cdn'))
				$link = 'http://code.jquery.com/jquery-'.config('jquery.version').'.min.js';
			else
				$link = 'pre:'.config('bower.path').'/jquery/jquery.min.js';
		}

		bors_use($link);
		$is_loaded = true;
	}

	static function plugin($name)
	{
		if(bors_page::template_data('jquery_plugin_'.$name.'_has_added'))
			return;

		jquery::load();

		// Если это одно название, то это имя
		if(preg_match('/^\w[\w\.\-]*\w$/', $name) && !preg_match('/\.js$/', $name))
			bors_page::add_template_data_array('js_include', '/_bors3rdp/jquery/plugins/jquery.'.$name.'.js');
		// Если путь не от корня сайта и не полный URL
		elseif($name[0] != '/' && !preg_match('/^http/', $name))
			bors_page::add_template_data_array('js_include', '/_bors3rdp/jquery/plugins/'.$name);
		else
			bors_page::add_template_data_array('js_include', $name);

		bors_page::add_template_data('jquery_plugin_'.$name.'_has_added', true);
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

		return bors_lcml::make_use('js', $link);
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

	static function appear($element, $function, $params = array())
	{
		if($params)
			$params = blib_json::encode_jsfunc($params);

		jquery::on_ready("$({$element}).{$function}(".($params?$params:'').")\n");
	}

	static function chrome_alt_fix()
	{
		return;

//		template_js('function showAlt(){$(this).replaceWith(this.alt)}');
//		template_js('function addShowAlt(selector){$(selector).error(showAlt).attr("src", $(selector).src)}');

//		self::on_ready('addShowAlt("img");');

		template_js_include("http://www.balancer.ru/_bors-ext/js/detect-image-enabled.js");

		self::on_ready('if(1) {
//		$.getScript("http://www.balancer.ru/_bors-ext/js/detect-image-enabled.js");
		if(top.is_image_disabled) {
			$("img[alt]").filter(function(){return $(this).attr("alt")}).replaceWith(function(){
				alt = $(this).attr("alt")
				return alt
			})}}');
	}
}

// Процедурное legacy. Надо будет перенести.

function template_jquery($link = NULL) { jquery::load($link); }
function template_jquery_plugin($name) { jquery::plugin($name); }

function template_jquery_plugin_post($name)
{
	template_jquery();

	if(bors_page::template_data('jquery_plugin_'.$name.'_has_added'))
		return;

	bors_page::add_template_data_array('js_include_post', '/_bors3rdp/jquery/plugins/'.$name);
	bors_page::add_template_data('jquery_plugin_'.$name.'_has_added', true);
}

function template_jquery_plugin_css($css)
{
	if(bors_page::template_data('jquery_plugin_'.$css.'_css_has_added'))
		return;

	bors_page::merge_template_data_array('css_list', array("/_bors3rdp/jquery/plugins/$css"));
	bors_page::add_template_data('jquery_plugin_'.$css.'_css_has_added', true);
}

function template_js($js_code)
{
	$hash = md5($js_code);
	if(bors_page::template_data('template_js_'.$hash))
		return;

	bors_page::add_template_data_array('javascript', trim($js_code));
	bors_page::add_template_data('template_js_'.$hash, true);
}

function template_js_post($js_code)
{
	$hash = md5($js_code);
	if(bors_page::template_data('template_js_'.$hash))
		return;

	bors_page::add_template_data_array('javascript_post', trim($js_code));
	bors_page::add_template_data('template_js_'.$hash, true);
}

function template_jquery_js($jquery_code)
{
	template_jquery();
	template_js("\$(function() {\n{$jquery_code}\n});\n");
}

function template_jquery_js_post($jquery_code)
{
	template_jquery();
	template_js_post("\$(function() {\n{$jquery_code}\n});\n");
}

function template_jquery_document_ready($js_code)
{
	template_jquery();
	bors_page::add_template_data_array('jquery_document_ready', trim($js_code));
}
