<?php

class bors_tasks_processor extends bors_cli
{
	function task_class() { return 'bors_task'; }

	function do_work()
	{
		// Проверяем, есть ли, вообще, задачи в очереди. Чтобы не мусорить потом
		// update, если они не нужны
		if(!bors_count($this->task_class(), array('runs_count<' => 3)))
			return;

		$processor_id = md5(microtime().uniqid());
		$foo = bors_foo($this->task_class());
		$db = $foo->db();

		// Обнуляем время запланированных задач, если оно уже наступило.
		$db->update(
			$foo->table_name(),
			array('exec_ts <= NOW()'),
			array('raw exec_ts' => NULL)
		);

		// Сбрасываем всех воркеров, если наступил таймаут задачи — наверное, воркер умер.
		$db->update(
			$foo->table_name(),
			array('(process_expire_ts < NOW() OR process_expire_ts IS NULL)'),
			array(
				'raw process_expire_ts'	=> NULL,
				'raw processor_id'		=> NULL,
			)
		);

		// Занимаем задачу
		$db->update(
			$foo->table_name(),
			array(
				'processor_id IS NULL',			// Задача никому не назначена
				'process_expire_ts IS NULL',	// Задача не в процессе обработки
				'exec_ts IS NULL',				// Задача не запланирована на будущее
				'runs_count<' => 3,				// Задача запускалась не более трёх раз (иначе — постоянная ошибка)
				'order' => 'priority DESC,create_ts',
				'limit' => 1,
			),
			array(
				'processor_id' => $processor_id,
				'raw process_expire_ts' => 'FROM_UNIXTIME('.(time()+300).')',
			)
		);

		// Читаем занятую задачу
		$task = bors_find_first($this->task_class(), array('processor_id' => $processor_id));
		if(!$task)
			return NULL;

		$task->set_runs_count($task->runs_count() + 1);
		$task->store();

		$worker = bors_load($task->worker_class_name(), NULL);
		if(!$worker)
			return "Can't load worker {$task->worker_class_name()} for task {$task->id()}";

		$target = bors_load($task->target_class_name(), $task->target_id());

		if($target)
			$target->set_page($task->page());
		elseif($task->target_class_name())
			bors_debug::syslog('tasks', "Target {$task->target_class_name()}({$task->target_id()}) load error. Is null.");

		$error = $worker->do_work($target);

		if($error)
		{
			// Если ошибка, то ничего не делаем, сбрасываем наш флаг процессора,
			// чтобы не читать его снова и ждём, пока таймаут сам истечёт — и по новой.
			$task->set_processor_id(NULL);
			$task->store();
		}
		else
			$task->delete();

		return $error;
	}
}
