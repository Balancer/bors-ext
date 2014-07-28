<?php

class bors_task extends bors_object_db
{
	function db_name() { return config('bors_core_db'); }
	function table_name() { return 'bors_tasks'; }

	function ignore_on_new_instance() { return true; }

	function table_fields()
	{
		return array(
			'id',
			'worker_class_name',
			'worker_id',
			'worker_method',
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

	static function add($worker, $target = NULL, $priority = 0, $exec_time = NULL)
	{
		$worker_class	= NULL;
		$worker_id		= NULL;
		$worker_method	= NULL;
		if(is_array($worker))
		{
			@list($worker_class, $worker_id, $worker_method) = $worker;
		}
		elseif(is_string($worker))
			$worker_class = $worker;
		else
			bors_debug::syslog('tasks-error', "Unknown worker: ".print_r($worker, true));

		$target_class	= NULL;
		$target_id		= NULL;
		$target_page	= NULL;

		if(is_object($target))
		{
			$target_class = $target->class_name();
			$target_id = $target->id();
			if(($page = $target->page()) && $page != 1)
				$target_page = $page;
		}
		elseif(is_array($target))
			@list($target_class, $target_id, $target_page) = $target;
		elseif($target)
			bors_debug::syslog('tasks-error', "Worker $worker. Unknown target: ".print_r($target, true));

		if(!$target_class)
			$target_class = '';

		if(!$target_id)
			$target_id = 0;

		if(!$target_page)
			$target_page = 0;

		bors_new(get_called_class(), array(
			'worker_class_name' => $worker_class,
			'worker_id'			=> $worker_id,
			'worker_method'		=> $worker_method,
			'target_class_name' => $target_class,
			'target_id'			=> $target_id,
			'target_page'		=> $target_page,
			'exec_time'			=> $exec_time,
			'priority'			=> $priority,
		));
	}
}
