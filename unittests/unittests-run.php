<?php

require_once './setup.php';
require_once BORS_CORE.'/init.php';

if(!@include_once(config('phpunit_include').'/Autoload.php'))
	require_once(config('phpunit_include').'/Framework.php');

require_once('inc/filesystem.php');

class BorsTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('BorsSuite');
		foreach(bors_dirs() as $dir)
		{
			if(file_exists(($tests_list_file = $dir.'/data/unittests-classes.list')))
				foreach(file($tests_list_file) as $class_name)
					if(($cn = trim($class_name)))
						$suite->addTestSuite(self::bors_class_test($cn));
			else
				"NF $tests_list_file\n";
		}

		foreach(search_dir(dirname(__FILE__).'/tests', $mask='\.php$') as $file)
		{
			require_once($file);
			if(preg_match('!unittests/tests/(.+)\.php$!', $file, $m))
				$suite->addTestSuite(str_replace('/','_', $m[1]).'_unittest');
		}

		$autotest = "class bors_class_autotest_helper extends PHPUnit_Framework_TestCase\n{\n\tfunction test_all()\n\t{\n";

		foreach(bors_dirs() as $dir)
		{
			foreach(search_dir($dir.'/classes', $mask='\.php$') as $file)
			{
				$content = file_get_contents($file);
				if(preg_match('!.*?class (\w+)!', $content, $m))
					if(preg_match('!function __unit_test\(!', $content))
						$autotest .= "\t\t{$m[1]}::__unit_test(\$this);\n";
			}
		}

		$autotest .= "\t}\n}\n";

		eval($autotest);
		$suite->addTestSuite('bors_class_autotest_helper');

		return $suite;
    }

	static function bors_class_test($class_name)
	{
//		var_dump(bors_dirs());
//		echo "Inc $class_name\n";
		$class_file = class_include($class_name);
//		echo "class file = $class_name\n";
		if(!file_exists(($test_class_file = preg_replace('/\.php$/', '.unittest.php', $class_file))))
		{
			echo "Not found {$test_class_file}";
			return false;
		}

		require_once($test_class_file);
		return $class_name.'_unittest';
	}
}
