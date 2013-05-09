<?php

// Click counter

class bors_ext_actions_clc extends bors_object
{
	function is_action() { return true; }

	function pre_show()
	{
		$target = bors_load_uri($this->id());
		if(!$target)
			return bors_throw("Can't count click on ".$this->id());

		$target->set_clicks($target->clicks() + 1);
		return go($target->url());
	}
}
