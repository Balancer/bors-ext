<?php

class bors_auto_archive_day extends bors_auto_archive_month
{
	function nav_name() { return bors_lower(month_name($this->page())); }
	function _title_def() { return ec('Архив ').call_user_func(array($this->main_class(), 'class_title_rpm'))
		.ec(' за ').$this->nav_name().' '.$this->year().ec(' года'); }

	function year() { return $this->id(); }
	function month() { return $this->arg('month'); }

	function body_data()
	{
		return array(
			'year' => $this->year(),
			'month' => $this->month(),
		);
	}
}
