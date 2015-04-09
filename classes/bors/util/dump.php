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

		echo "class:      ", $x->class_name(), PHP_EOL;
		echo "id:         ", $x->id(), PHP_EOL;
		echo "class_file: ", $x->class_file(), PHP_EOL;

		if($data = $x->data)
		{
			foreach($data as $key => $value)
			{
				if(preg_match('/_time|_ts|_date/', $key) && preg_match('/^\d+$/', $value))
					$data[$key] = "$value (".date('r', $value).")";
			}

			echo "data: ", json_encode($data, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), PHP_EOL;
		}

		$data = array();
		foreach($x->auto_objects() as $key => $value)
			$data[$key] = self::debug_title($x->get($key));

		if($data)
			echo "auto_objects: ", json_encode($data, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), PHP_EOL;

		$data = array();
		foreach($x->auto_targets() as $key => $value)
			$data[$key] = self::debug_title($x->get($key));

		if($data)
			echo "auto_targets: ", json_encode($data, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), PHP_EOL;

		config_set('_debug_go_uri', NULL);

		ob_start();
		$x->pre_show();
		ob_end_clean();

		if($go = config('_debug_go_uri'))
		{
			echo "go:         ", $go, PHP_EOL;
			echo "-----------------------------------------------------------------", PHP_EOL;
			self::run(array($go));
		}
	}

	static function debug_title($x)
	{
		if(!is_object($x))
			return $x;

		$title = $x->get('title');
		return get_class($x).'('.$x->id().')' . ($title ? " = '$title'" : '');
	}
}
