<?php

class bors_views_main extends bors_paginated
{
	function _title_def() { return bors_ucfirst(bors_lib_object::get_foo($this->main_class(), 'class_title_m')); }
	function nav_name() { return bors_lib_object::get_foo($this->main_class(), 'class_title_m'); }

	function _main_class_def()
	{
		$class_name = str_replace('_views_main', '', $this->class_name());
		$class_name = str_replace('_main', '', $class_name);
		return join('_', array_map('bors_unplural', explode('_', $class_name)));
	}

	function _project_name_def() { return bors_core_object_defaults::project_name($this); }
	function _section_name_def() { return bors_core_object_defaults::section_name($this); }
	function _config_class_def() { return bors_core_object_defaults::config_class($this); }

	function search_form()
	{
		$search = bors_load_ex('bors_auto_search', NULL, array(
			'class' => $this->section_name(),
		));

		return $search->body().'<br/>';
	}
}
