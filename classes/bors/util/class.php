<?php

config_set('phpunit_include', 'PHPUnit');

if(!include_once(config('phpunit_include').'/Autoload.php'))
	require_once(config('phpunit_include').'/Framework.php');

class bors_util_class
{
	static function run($argv)
	{
//		var_dump($argv, config('project.name'));
		@list($class_name, $action, $name, $type) = $argv;

		if($class_name[0] == '_')
			$class_name = config('project.name') . $class_name;

		if(preg_match('/\.php$/', $class_name))
			$class_name = bors_util::file_php_to_classname($class_name);

		echo "\twork with $class_name: $action $name(".@$type.")\n";

		if(!preg_match('/^[a-z]\w+[a-z]$/', $class_name))
		{
			blib_cli::out("%C%RIncorrect class name: '$class_name'%C%n");
			break;
		}

		switch($action)
		{
			// bors class _directory_aviation_wtc create
			case 'create':
				$type = $name; // Так как в команде на один параметр меньше.

				if(!$type)
					$type = 'yaml_db';
				bors_tools_codegen::class_create($type, $class_name, BORS_SITE);
				break;

			// bors class airlines.php add create_time timestamp
			// bors class _directory_company add is_published
			case 'add':
				$foo = bors_foo($class_name);
				$storage = $foo->storage();
				$storage->add_field($class_name, $name, $type);
				blib_cli::out("%C%YAdd field $name%C%n");
				break;

			case 'del':
				$confirm = blib_cli::input("%C%RType yes to confirm delete field $name%C%n: [no]", 'no');
				if($confirm != 'yes')
				{
					blib_cli::out("%C%YCancel remove field $name%C%n");
					break;
				}

				$foo = bors_foo($class_name);
				$storage = $foo->storage();
				$storage->del_field($class_name, $name);
		}
	}
}
