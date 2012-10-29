<?php

class twitter_bootstrap
{
	function load()
	{
		bors_use('pre:/_bors3rdp/'.config('bootstrap.path').'/css/bootstrap.min.css');
		bors_use('pre:/_bors3rdp/'.config('bootstrap.path').'/css/bootstrap-responsive.min.css');
		jquery::load();
		bors_use('/_bors3rdp/'.config('bootstrap.path').'/js/bootstrap.min.js');
		config_set('css_bootstrap_is_loaded', true);
	}
}
