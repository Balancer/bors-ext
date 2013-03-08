<?php

//	http://www.balancer.ru/_bors/callback/opauth

class bors_external_callback extends bors_object
{
	function can_be_empty() { return false; }

	function is_loaded()
	{
		$class_name = 'bors_callback_'.$this->id();
		$x = bors_load($class_name, NULL);
		if(!$x || !$x->is_callback())
			return false;

		return $x;
	}
}
