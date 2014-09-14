<?php

/**
	@nav_name = архив
*/

class bors_auto_archive_main extends bors_page
{
	function _title_def()
	{
		return ec('Архив ').call_user_func(array($this->main_class(), 'class_title_rpm'));
	}

	function _item_type_def()
	{
		if($class = $this->args('class'))
			return blib_grammar::singular($class);

		bors_throw(ec("Не задан тип искомых объектов и его не удаётся вычислить"));
	}

	function _project_name_def()
	{
		if($project = $this->args('project'))
			return $project;

		return config('project.name');
	}

	function _section_name_def()
	{
		if($section_name = $this->args('section_name'))
			return $section_name;

		$parts = explode('_', $this->main_class());
		return bors_plural($parts[1]);
	}

	function _main_class_def()
	{
		return $this->project_name().'_'.$this->item_type();
	}

	function body_data()
	{
		return array(
			'years' => bors_find_all($this->main_class(), array(
				'*set' => 'YEAR(create_time) AS `year`, COUNT(*) AS `count`',
				'group' => '`year`',
				'order' => '`year`',
			))
		) + parent::body_data();
	}
}
