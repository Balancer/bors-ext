<?php

class bors_util_bench
{
	static function run($argv)
	{
		$test = $argv[0];
		if(!($times = @$argv[1]))
			$times = 1000;

		if(preg_match('/^(\w+)\.php$/', $test, $m))
		{
			$content = file_get_contents($test);
			if(!preg_match('/class (\w+)/', $content, $mm))
				return print "Unknown class in $test\n";

			$class_name = $mm[1];

			if(!preg_match('/function __benchmark/', $content))
				return print "Absent __benchmark function in class $class_name";

			@list($functions, $args, $times2) = call_user_func(array($class_name, '__benchmark'));
			if($times2)
				$times = $times2;
			if(!$args)
				$args = array();

			blib_benchmark::run($functions, $args, $times);

			return;
		}

		echo "Can't test $test\n";
	}
}
