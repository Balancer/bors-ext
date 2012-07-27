<?php

class bors_util_test
{
	static function run($argv)
	{
		$test = $argv[0];
		if(preg_match('/^(\w+)\.php$/', $test, $m))
		{
			$content = file_get_contents($test);
			if(!preg_match('/class (\w+)/', $content, $mm))
				return print "Unknown class in $test\n";

			$class_name = $mm[1];

			if(!preg_match('/function __unit_test/', $content))
				return print "Absent __unit_test function in class $class_name";

			self::test_class($class_name);
			return;
		}

		echo "Can't test $test\n";
	}

	static function test_class($class_name)
	{
		config_set('phpunit_include', 'PHPUnit');

		if(!include_once(config('phpunit_include').'/Autoload.php'))
			require_once(config('phpunit_include').'/Framework.php');


		$autotest = "class bors_class_autotest_helper extends PHPUnit_Framework_TestCase\n{\n\tfunction test_all()\n\t{\n";
		$autotest .= "\t\t{$class_name}::__unit_test(\$this);\n";
		$autotest .= "\t}\n}\n";

		eval($autotest);

		$suite = new PHPUnit_Framework_TestSuite('bors_class_autotest_helper');
		$runner = new PHPUnit_TextUI_TestRunner();
		$result = $runner->doRun($suite);
	}
}
