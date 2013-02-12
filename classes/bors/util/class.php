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

		// Если имя класса из одних букв, то это имя относительно текущего каталога
		if(preg_match('/^[a-z]+$/', $class_name))
		{
			// Поднимаемся по уровням каталогов выше, пока не доберёмся до classes
			$classes_path = dirname($init_path = getcwd());
			do
			{
				$classes_path = dirname($classes_path);
			} while($classes_path > '/' && !preg_match('!/classes$!', $classes_path));

			// Если, действительно, нашли каталог /classes/
			if(preg_match('!/classes$!', $classes_path))
				$class_name = str_replace('/', '_', str_replace($classes_path.'/', '', $init_path)) . '_' . $class_name;
		}


		if($class_name[0] == '_')
			$class_name = config('project.name') . $class_name;

		// Если имя класса оканчивается на .php, то это файл и имя берётся из него.
		if(preg_match('/\.php$/', $class_name))
			$class_name = bors_util::file_php_to_classname($class_name);

		echo "\twork with $class_name: $action $name(".@$type.")\n";

		if(!preg_match('/^[a-z]\w+[a-z]$/', $class_name))
			return blib_cli::out("%C%RIncorrect class name: '$class_name'%C%n");

		switch($action)
		{
			// @list($class_name, $action = 'create', $table_name) = $argv;
			// bors class <class_name> create [table_name] [type]
			// bors class _directory_aviation_wtc create
			// bors class wtc create aviation_wtc
			case 'create':
				$table_name = @$argv[2];	// В команде другой порядок
				$type = @$argv[3];

				if(!$type)
					$type = 'yaml_db';

				blib_cli::out("%C%GCreate class '$class_name' as $type%C%n");
				bors_tools_codegen::class_create($type, $class_name, BORS_SITE, $table_name);
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
