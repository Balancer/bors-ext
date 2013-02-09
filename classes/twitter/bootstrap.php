<?php

class twitter_bootstrap
{
	static function load()
	{
		bors_use('pre:/_bors3rdp/'.config('bootstrap.path').'/css/bootstrap-responsive.min.css');
		bors_use('pre:/_bors3rdp/'.config('bootstrap.path').'/css/bootstrap.min.css');

		jquery::load();
		bors_use('/_bors3rdp/'.config('bootstrap.path').'/js/bootstrap.min.js');
		config_set('css_bootstrap_is_loaded', true);
	}

	static function jquery_ui()
	{
		bors_use('pre:/_bors3rdp/bootstrap-plugins/'.config('bootstrap.jquery_ui').'/css/custom-theme/jquery-ui-1.8.16.custom.css');
		bors_use('/_bors3rdp/bootstrap-plugins/'.config('bootstrap.jquery_ui').'/js/jquery-ui-1.8.16.custom.min.js');
	}
}
