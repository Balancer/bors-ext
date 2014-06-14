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

			if(preg_match('/^\s*namespace\s*(.+?);\s*$/m', $content, $mm))
				$ns = $mm[1]."\\";
			else
				$ns = '';

var_dump($mm, $ns);

			if(!preg_match('/function __dev/', $content))
				return blib_cli::out("%rAbsent __dev function in class $class_name%n\n");

			call_user_func(array($ns.$class_name, '__dev'));
			return;
		}

		echo "Can't test $test\n";
	}
}
