<?php

class bors_task extends bors_object_db
{
	function db_name() { return config('bors_core_db'); }
	function table_name() { return 'bors_tasks'; }

	function table_fields()
	{
		return array(
			'id',
			'worker_class_name',
			'target_class_name',
			'target_id',
			'target_page',
			'create_time' => array('name' => 'UNIX_TIMESTAMP(`create_ts`)'),
			'exec_time' => array('name' => 'UNIX_TIMESTAMP(`exec_ts`)'),
			'priority',
			'process_time' => array('name' => 'UNIX_TIMESTAMP(`process_ts`)'),
			'process_expire_time' => array('name' => 'UNIX_TIMESTAMP(`process_expire_ts`)'),
			'processor_id',
			'runs_count',
		);
	}

	function add($worker, $target = NULL, $priority = 0, $exec_time = NULL)
	{
		bors_new($this->class_name(), array(
			'worker_class_name' => $worker,
			'target_class_name' => $target ? $target->class_name() : NULL,
			'target_id' => $target ? $target->id() : NULL,
			'target_page' => $target && ($page = $target->page()) && $page != 1 ? $page : NULL,
			'exec_time' => $exec_time,
			'priority' => $priority,
		));
	}
}
