<?php

// PHPUnit теперь берётся из Composer
// require_once('composer/vendor/autoload.php');

if(!class_exists('PHPUnit_Framework_TestCase'))
{
	blib_cli::out("%RCan't load PHPUnit.%n Use:\n\t%Wcomposer require phpunit/phpunit=*%n\n");
	echo class_include('blib_cli');
	exit();
}

class bors_util_test
{
	static function run($argv)
	{
		$test = $argv[0];

		if(preg_match('/^(\w+)\.php$/', $test, $m) && file_exists($test_file = "{$m[1]}.unittest.php"))
			$test = $test_file;

		if(preg_match('/^(\w+)\.unittest\.php$/', $test, $m))
		{
			$content = file_get_contents($test);

			if(!preg_match('/class (\w+)/', $content, $mm))
				return print "Unknown class in $test\n";

			$class_name = $mm[1];

			require($test);

			$suite = new PHPUnit_Framework_TestSuite();
			$suite->addTestSuite($class_name);
			$runner = new PHPUnit_TextUI_TestRunner();
			$result = $runner->doRun($suite);
			return;
		}

		if(preg_match('/^(\w+)\.php$/', $test, $m))
		{
			$content = @file_get_contents($test);
			if(!$content)
				return blib_cli::out("%rCan't read file $test%n\n");

			if(!preg_match('/class (\w+)/', $content, $mm))
				return print "Unknown class in $test\n";

			$class_name = $mm[1];

			if(preg_match('/^\s*namespace\s+([\w\\\\]+);/m', $content, $mm))
				$class_name = $mm[1]."\\".$class_name;

			if(!preg_match('/function __unit_test/', $content))
				return blib_cli::out("%rAbsent __unit_test function in class $class_name%n\n");

			self::test_class($class_name);
			return;
		}

		echo "Can't test $test\n";
	}

	static function test_class($class_name)
	{
		$autotest = "class bors_class_autotest_helper_loc extends PHPUnit_Framework_TestCase\n{\n\tfunction test_all()\n\t{\n";
		$autotest .= "\t\t{$class_name}::__unit_test(\$this);\n";
		$autotest .= "\t}\n}\n";

		eval($autotest);

		$suite = new PHPUnit_Framework_TestSuite('bors_class_autotest_helper_loc');
		$runner = new PHPUnit_TextUI_TestRunner();
		$result = $runner->doRun($suite);
	}
}
