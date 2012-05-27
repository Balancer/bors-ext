<?php

bors_use('time_month_name');

// http://matf.aviaport.ru/contacts/archive/2012/4/

class bors_auto_archive_month extends bors_auto_archive_year
{
	function year() { return $this->id(); }
	function month() { return $this->arg('month'); }

	function nav_name() { return bors_lower(month_name($this->month())); }
	function _title_def() { return ec('Архив ').call_user_func(array($this->main_class(), 'class_title_rpm'))
		.ec(' за ').$this->nav_name().' '.$this->year().ec(' года'); }

	function body_data()
	{
		return array(
			'year' => $this->year(),
			'month' => $this->month(),
		);
	}
}
