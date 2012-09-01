<?php

/**
	Простой запуск указанного в параметрах PHP-файла с предварительно
	инициированным фреймворком. Полезно в тестах.
*/

class bors_util_run
{
	static function run($argv)
	{
		$file = $argv[0];

		if(preg_match('/^(\w+)\.php$/', $file, $m))
		{
			require $file;
			return;
		}

		echo "Can't run $file\n";
	}
}
