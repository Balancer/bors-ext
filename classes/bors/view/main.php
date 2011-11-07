<?php

class bors_view_main extends bors_paginated
{
	function title() { return bors_lib_object::get_foo($this->main_class(), 'class_title_m'); }
	function nav_name() { return bors_lib_object::get_foo($this->main_class(), 'class_title_m'); }

	function main_class()
	{
		$class_name = str_replace('_view_main', '', $this->class_name());
		return bors_unplural($class_name);
	}
}
