<?php

class bors_ext_action extends bors_object
{
	function can_be_empty() { return false; }

	function is_loaded()
	{
		$class_name = $this->id();
		if(!preg_match('/^\w+$/', $class_name))
			return false;

		if($class_name[0] == '_')
			$class_name = 'bors_ext_actions'.$class_name;

		$x = bors_load($class_name, $this->args('target'));
		if(!$x || !$x->get('is_action'))
			return false;

		return $x;
	}

	static function __dev()
	{
		echo config('debug_hidden_log_dir'), PHP_EOL;
		$x = bors_load('bors_ext_action', '_clc');
		echo $x->debug_title();
	}
}
