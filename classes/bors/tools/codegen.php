<?php

class bors_tools_codegen
{
	static function class_create($class_type, $class_name, $project_root)
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

//		file_put_contents($class_file, "extends ");
	}

	static $types = array(
		'yaml_db' => array('file_type' => 'yaml', 'extends' => '_object_db')
	);
}
