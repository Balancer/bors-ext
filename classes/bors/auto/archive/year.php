<?php

/**
	@nav_name = %this.year%
*/

bors_use('time_month_name');

class bors_auto_archive_year extends bors_auto_archive_main
{
	function _title_def() { return ec('Архив ').call_user_func(array($this->main_class(), 'class_title_rpm')).ec(' за ').$this->year().ec(' год'); }

	function year() { return $this->id(); }

	function body_data()
	{
		return array(
			'months' => bors_find_all($this->main_class(), array(
				'*set' => 'YEAR(create_time) AS `year`, MONTH(create_time) AS `month`, COUNT(*) AS `count`',
				'YEAR(create_time)=' => $this->id(),
				'group' => '`year`,`month`',
				'order' => '`year`,`month`',
			))
		);
	}
}
