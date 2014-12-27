<?php

class bors_util_dump
{
	static function run($argv)
	{
		if(preg_match('!http://!', @$argv[0]))
		{
			$x = bors_load_uri($argv[0]);
			if(!$x)
			{
				echo "Can't load {$argv[0]})\n";
				return;
			}
		}
		else
		{
			$class_name = @$argv[0];
			$object_id = @$argv[1];
			$x = bors_load($class_name, $object_id);
			if(!$x)
			{
				echo "Can't load $class_name($object_id)\n";
				return;
			}
		}

		echo json_encode($x->data, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}
}
