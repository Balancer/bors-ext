<?php

/**
	Использование WYSIWYG-редактора BB-кода WysiBB
	http://www.wysibb.com/
*/

class wysibb
{
	static function init($element)
	{
		jquery::load();
		jquery::plugin(config('jquery.wysibb.path').'/jquery.wysibb.min.js');
		jquery::on_ready("\$('$element').wysibb();");
		$theme = config('bower.path')."/jqjquery-wysibb/theme/default/wbbtheme.css";
//		$theme = http://cdn.wysibb.com/css/default/wbbtheme.css;
		bors_page::add_template_data_array('head_append', "<link rel=\"stylesheet\" href=\"{$theme}\" />");
	}
}
