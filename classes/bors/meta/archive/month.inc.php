<?php

function body_data()
{
	$year  = $this->year();
	$month = $this->month();
	$start = blib_month::begin($year, $month);
	$stop  = blib_month::end($year, $month);

	$items = bors_find($this->main_class())
		->between('create_time', $start, $stop)
		->where($this->where())
		->order('create_time')
		->all();

//	print_dd($items);

	$objects_title = $this->target_class_title_pg();

	return compact('year', 'month', 'items');
}
