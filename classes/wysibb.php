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
		jquery::on_ready("\$($element).wysibb();");
	}
}
