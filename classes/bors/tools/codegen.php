<?php

class bors_tools_codegen
{
	static function class_create($class_type, $class_name, $project_root, $table_name = NULL, $db_name = NULL)
	{
		var_dump($class_type, $class_name, $project_root);
		$desc = @self::$types[$class_type];

		if(empty($desc))
			bors_throw("Unknown class type $class_type");

		extract($desc);
		if(empty($extension))
			$extension = $file_type;

		$class_file = $project_root . '/classes/' . str_replace('_', '/', $class_name) . '.' . $extension;
		echo "\tClass file = $class_file\n";
		if(file_exists($class_file))
			bors_throw("Class $class_name already exists in $class_file");

		if(!$table_name)
			$table_name = str_replace(config('project.name').'_', '', $class_name);

		$extends = config('project.name').$extends;

		switch($class_type)
		{
			case 'yaml_db':
				$code = "extends: $extends

config_class: ".config('project.name')."_config

table_name: $table_name
properties:
	- id
	- title
	- create_time: UNIX_TIMESTAMP(`create_ts`)
	- modify_time: UNIX_TIMESTAMP(`modify_ts`)
	- owner_id
	- last_editor_id
";
				break;
			default:
				$code = NULL;
		}

		if(!$code)
			bors_throw("Can't make code");

		file_put_contents($class_file, $code);

		$foo = bors_foo($class_name);
		if(!$foo)
			bors_throw("Can't load created class $class_name");

		$foo->storage()->create_table();
	}

	static $types = array(
		'yaml_db' => array('file_type' => 'yaml', 'extends' => '_object_db')
	);
}
