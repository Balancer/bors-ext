<?php

class twitter_bootstrap
{
	static function load($responsive = true)
	{
		$path = config('bootstrap.path');
		// Пишется раньше, так как следующее добавление будет pre
		if($responsive)
			bors_use('pre:'.$path.'/css/bootstrap-responsive.min.css');

		bors_use('pre:'.$path.'/css/bootstrap.min.css');

		jquery::load();
		bors_use(''.$path.'/js/bootstrap.min.js');
		config_set('css_bootstrap_is_loaded', true);
	}

	static function jquery_ui()
	{
		bors_use('pre:/_bors-3rd/opt/bootstrap-plugins/'.config('bootstrap.jquery_ui').'/css/custom-theme/jquery-ui-1.8.16.custom.css');
		bors_use('/_bors-3rd/opt/bootstrap-plugins/'.config('bootstrap.jquery_ui').'/js/jquery-ui-1.8.16.custom.min.js');
	}

	static function raw_message($params = array())
	{
		self::load();

		if(!is_array($params))
			$params['title'] = $params;

		return bors_templates_smarty::fetch('xfile:bootstrap/index.tpl', $params);
	}
}
