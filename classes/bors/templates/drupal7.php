<?php

class bors_templates_drupal7
{
	function find_template($tpl)
	{
		foreach(bors_dirs() as $dir)
			if(file_exists($x = "$dir/htdocs/_bors-ext/drupal7/$tpl"))
				return $x;

		bors_throw(ec("Can't find drupal7 template '$tpl'"));
		return NULL;
	}

	function fetch($template, $data)
	{
		$htroot = preg_replace('!^.+htdocs/!', '/', $template);

		$html = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
<head>
<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"$htroot/css/acquia-prosper-style.css\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"$htroot/css/colors.css\" />
";

		$page = array(
			'header_top' => '== header-top ==',
			'header' => '== header ==',
			'main_menu' => '== main_menu ==',
			'preface_top' => '== preface_top ==',
			'sidebar_first' => '== sidebar_first ==',
			'preface_bottom' => '== preface_bottom ==',
			'help' => '== help ==',
			'content' => $data['body'],
			'sidebar_second' => '== sidebar_second ==',
			'postscript_top' => '== postscript_top ==',
			'postscript_bottom' => '== postscript_bottom ==',
			'footer' => '== footer ==',
		);

		$grid_width = '1000px';
		$main_group_width = '700px';
		$content_group_width = 'auto';
		$title_prefix = 'title_prefix';
		$title_suffix = 'title_suffix';
		$action_links = 'action_links';


		$obj = bors()->main_object();
		$logo = $obj->get_find('site_logo');
		$site_name = $obj->get_find('site_name');
		$site_slogan = $obj->get_find('site_slogan');
		$title = $obj->get('page_title');

		$breadcrumb = 'breadcrumb';
		$messages = 'messages';
		$tabs = 'tabs';

		$front_page = $obj->get_find('site_fron_page', '/');

		ob_start();
		require_once("$template/page.tpl.php");
		$html .= ob_get_contents();
		ob_end_clean();
//		var_dump($template);
//		var_dump($data);
		return $html;
	}
}

function render($code)
{
	return $code;
}

function check_url($url)
{
	return $url;
}

// Перевод, судя по всему
function t($text)
{
	return $text;
}

function theme($block, $params)
{
	return "theme[$block]".print_r($params, true)."[/$block]";
}
