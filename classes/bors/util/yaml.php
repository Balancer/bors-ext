<?php

/**
	Парсим yaml и делаем дамп результата. Для отладки.
*/

class bors_util_yaml
{
	static function run($argv)
	{
		$file = $argv[0];

		$data = bors_data_yaml::load($file);
		print_r($data);
	}
}
