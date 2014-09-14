<?php

// var_dump(BORS_HOST, BORS_SITE);

global $pos;
$pos = $argv[1];

//config_set('mysql_trace_show', true);
config_set('debug_hidden_log_dir', __DIR__);

$delay = 0.5;

function do_work()
{
	global $pos;
//	echo "\r$pos";
	blib_cli::out("\r%K$pos %n");
//	blib_cli::out("\t%wDo work by ".getmypid()."%n");
	$processor = bors_foo('bors_tasks_processor');

	try
	{
		$res = $processor->do_work();
		if($res)
		{
			echo '+';
			blib_cli::out(" %CResult %n");
			var_dump($res);
		}
	}
	catch(Exception $e)
	{
		blib_cli::out("\r%RException%n\n");
		blib_cli::out("%K".blib_exception::factory($e)."%n\n");
		exit();
	}
}

$next_name = 'task-processor-next-check';

$next_run = false;

// Бесконечный цикл
while(true)
{
	$next_run_time = bors_var_cache::get($next_name);

	// Если переменная отложенного запуска не указана или время истекло,
	// то запускаем обработку
	if($next_run || $next_run_time <= microtime(true))
	{
		// Собственно, работа
		// Если что-то сделали, то сразу идём на обработку следующей задачи
		if(do_work())
		{
			$next_run = true;
			usleep(100000);
			continue;
		}

		// Если ничего не сделали, то встаём в общую задержку
		$next_run = false;
	}

	// Если в очереди кто-то есть, то становимся в ней последними с задержкой в секунду.
	$next_run_time = bors_var_cache::get($next_name);
	if($next_run_time < microtime(true))
		$next_run_time = microtime(true);

	$next_run_time += $delay;

	bors_var_cache::set($next_name, $next_run_time);

	// Спим до нужного момента:
	$usleep = intval(1000000*($next_run_time - microtime(true) + 0.001));  // Небольшой фикс округлений
//	blib_cli::out("%w\tusleep($usleep) by ".getmypid()."%n");
	$next_run = true;
	usleep($usleep);
}
