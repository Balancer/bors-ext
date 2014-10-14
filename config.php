<?php

$d = dirname(__FILE__);
if(file_exists($d.'/config-3rd.ini'))
	bors_config_ini($d.'/config-3rd.ini');

if(file_exists($d.'/config-3rd.php'))
	require_once($d.'/config-3rd.php');

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
	jquery::on_ready($js_code);
}
