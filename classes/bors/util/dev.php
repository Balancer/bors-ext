<?php

class bors_util_dev
{
	static function run($argv)
	{
		$test = $argv[0];

		if(preg_match('/^(\w+)\.dev\.php$/', $test, $m))
		{
			require($test);
			return;
		}

		if(preg_match('/^(\w+)\.php$/', $test, $m))
		{
			$content = file_get_contents($test);
			if(!preg_match('/class (\w+)/', $content, $mm))
				return print "Unknown class in $test\n";

			$class_name = $mm[1];

			if(!preg_match('/function __dev/', $content))
				return print "Absent __dev function in class $class_name";

			call_user_func(array($class_name, '__dev'));
			return;
		}

		echo "Can't test $test\n";
	}
}
