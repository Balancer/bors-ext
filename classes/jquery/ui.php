<?php

class jquery_ui
{
	static function load()
	{
		jquery::plugin('http://code.jquery.com/ui/1.8.3/jquery-ui.min.js');
		bors_use('http://code.jquery.com/ui/1.8.3/themes/base/jquery-ui.css');
	}
}
