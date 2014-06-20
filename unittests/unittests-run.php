<?php

//if($bus = getenv('BORS_UNITTEST_SITE'))
//	define('BORS_SITE', $bus);

require_once dirname(__FILE__).'/setup.php';
require_once BORS_CORE.'/init.php';

//config_set('phpunit_include', 'PHPUnit');
//if(!@include_once(config('phpunit_include').'/Autoload.php'))
//	@include_once(config('phpunit_include').'/Framework.php');

// PHPUnit теперь берётся из Composer
//require_once('composer/vendor/autoload.php');

require_once('inc/filesystem.php');

function unittest_dirs()
{
	if(getenv('BORS_UNITTEST_PROJECT_NAME'))
		return array(BORS_SITE);

	return bors_dirs();
}

class BorsTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('BorsSuite');
		foreach(unittest_dirs() as $dir)
		{
			if(file_exists(($tests_list_file = $dir.'/data/unittests-classes.list')))
				foreach(file($tests_list_file) as $class_name)
					if(($cn = trim($class_name)))
						$suite->addTestSuite(self::bors_class_test($cn));
			else
				"NF $tests_list_file\n";
		}

		if(!getenv('BORS_UNITTEST_PROJECT_NAME'))
			foreach(search_dir($GLOBALS['UNITTESTS_DIR'].'/tests', $mask='\.php$') as $file)
			{
				require_once($file);
				if(preg_match('!unittests/tests/(.+)\.php$!', $file, $m))
					$suite->addTestSuite(str_replace('/','_', $m[1]).'_unittest');
			}

		$autotest = "class bors_class_autotest_helper extends PHPUnit_Framework_TestCase\n{\n\tfunction test_all()\n\t{\n";

		foreach(unittest_dirs() as $dir)
		{
			foreach(search_dir($dir.'/classes', $mask='\.php$') as $file)
			{
				// classes/bors/object/simple.unittest.php
				if(preg_match('!^.*?/classes/([\w/]+)\.unittest\.php$!', $file, $m))
				{
					$class_name = str_replace('/', '_', $m[1]);
//					echo "$file -> $class_name\n";
					$suite->addTestSuite(self::bors_class_test($class_name));
				}

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
//		var_dump(unittest_dirs());
//		echo "Inc $class_name\n";
		$class_file = class_include($class_name);
//		echo "class file = $class_name\n";
		if(!file_exists(($test_class_file = preg_replace('/\.php$/', '.unittest.php', $class_file))))
		{
			echo "=== Not found '{$test_class_file}' ===\n";
			return false;
		}

		require_once($test_class_file);
		return $class_name.'_unittest';
	}
}
