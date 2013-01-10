<?php

class bors_util
{
	private $tpl_vars = array();

	function main($argv)
	{
		$this->set_var('project_name', config('project.name'));

		$script = array_shift($argv);
		$action = array_shift($argv);
		switch($action)
		{
			case 'create':
				return $this->create($argv);
			case 'alter':
				return $this->alter($argv);
		}

		if(preg_match('/^\w+$/', $action) && class_include($cls = 'bors_util_'.$action))
			return $cls::run($argv);

		return $this->do_not_found("Not found action $action\n");
	}

	function set_var($name, $value) { return $this->tpl_vars[$name] = $value; }

	function tpl_var($name)
	{
		if(array_key_exists($name, $this->tpl_vars))
			return $this->tpl_vars[$name];

		return "[unknown_var_($name)]";
	}

	function do_not_found($message)
	{
		echo $message.PHP_EOL;
		return;
	}

	function create($args)
	{
		$type = array_shift($args);
		switch($type)
		{
			case 'xref':
				return $this->create_xref($args);
		}

		return $this->do_not_found("Not found action create $type\n");
	}

	function create_xref($args)
	{
		$args = join(" ", $args);
		if(preg_match('!^(\w+)$!i', $args))
			return $this->create_xref_class_to_any($args);

		return do_not_found("Not found action create xref $args\n");
	}

	// Синтаксис: bors create xref aviaport_common_theme
	// Объект конкретного класса, связанный с любыми объектами (т.е. в таблице — target_class_name, target_object_id)
	function create_xref_class_to_any($class_name_from)
	{
		$this->set_var('from_class_name', $class_name_from);

		$project_name = config('project.name');
		$this->create_class("{$project_name}_xref_c2a", "bors_xref_c2a", "meta_object_db");
		$this->create_class("{$class_name_from}_xref_any", "{$project_name}_xref_c2a", "xref_c2a");

		$this->create_table("{$class_name_from}_xref_any");
	}

	function create_class($class_name, $extends, $template)
	{
		$file = BORS_SITE.'/classes/'.str_replace('_', '/', $class_name).'.php';
		if(file_exists($file))
			return;

		mkpath(dirname($file), 0750);

		$content = file_get_contents(dirname(__FILE__).'/bors-templates/'.$template.'.php.tpl');
		$this->set_var('class_name', $class_name);
		$this->set_var('extends', $extends);
		$this->set_var('table_name', bors_plural(self::object_name($this->tpl_var('from_class_name'))).'_x_any');
		$this->set_var('from_name', self::object_name($this->tpl_var('from_class_name')));

		$self = $this;
		$content = preg_replace_callback('/(%(\w+)%)/',
			function($m) use ($self) { return $self->tpl_var($m[2]); },
			$content);

//		echo "$content\n";
		file_put_contents($file, $content);
		echo "Created $file\n";
	}

	static function object_name($class_name)
	{
		return array_pop(explode('_', $class_name));
	}

	function create_table($class_name)
	{
		$foo = new $class_name(NULL);
		$foo->storage()->create_table($class_name);
	}

	function alter($args)
	{
		$class_name = array_shift($args);
		$file = BORS_SITE.'/classes/'.str_replace('_', '/', $class_name).'.php';
		if(!file_exists($file))
			return $this->do_not_found("Not found class $class_name at $file\n");

		$content = file_get_contents($file);

		$type = array_shift($args);
		switch($type)
		{
			case 'add':
				$field = array_shift($args);
				if(preg_match("!function table_fields[^\}]+'$field'!", $content))
					return $this->do_not_found("Field $field already exists in class $class_name");

				$content = preg_replace("!(function table_fields[^\}]+return array\([^\}]+\n)(\t+)(.+?)(\n\s*\);.*?\})!s", "$1$2$3\n$2'$field',$4", $content);
				file_put_contents($file, $content);
				echo "Updated $file\n";
				$foo = new $class_name(NULL);
				$foo->storage()->add_field($class_name, $field);

				return;

			default:
				return $this->do_not_found("Not found action alter $type");
		}

	}

	static function file_php_to_classname($filename)
	{
		$contents = file_get_contents($filename);
		if(preg_match('!^\s*class\s+(\w+)\s*!m', $contents, $m))
			return $m[1];

		return NULL;
	}
}
