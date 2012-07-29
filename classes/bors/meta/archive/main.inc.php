<?php

function body_data()
{
	$counts = bors_count($this->main_class(), $this->where() + array(
		'group' => '*BYMONTHS(create_time)*',
		'order' => 'group_date',
	));

	$years = array();
	foreach($counts as $date => $count)
	{
		list($year, $month) = explode('-', $date);
		$years[$year][$month] = array(
			'month_name' => blib_month::name($month),
			'count' => $count,
		);
	}

	$years = array_reverse($years, true);

	$objects_title = $this->target_class_title_pg();

	return compact('objects_title', 'years');
}
