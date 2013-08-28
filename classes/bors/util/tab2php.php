<?php

class bors_util_tab2php
{
	static function run($argv)
	{
		$table = @$argv[0];
		if(!$table)
			return print "Not defined table\n";

		if(preg_match('/^(\w+)\.(\w+)$/', $table, $m))
		{
			$table = $m[2];
			$db = $m[1];
		}
		else
			$db    = empty($argv[2]) ? config('main_bors_db') : $argv[2];

		$dbh = new driver_mysql($db);

		$x = $dbh->get("SHOW CREATE TABLE $table");

		$class_name = bors_unplural($table);
		$item_name = preg_replace('/^.*_(\w+)$/', '$1', $class_name);
		$items_name = bors_plural($item_name);

		$project = bors_lower($db);

		$code = array();

		$code[] = "<?php\n";
		$code[] = "class {$project}_{$class_name} extends bors_object_db\n{";
		$code[] = "\tfunction storage_engine() { return 'bors_storage_mysql'; }";
		$code[] = "\tfunction db_name() { return '$db'; }";
		$code[] = "\tfunction table_name() { return '$table'; }";
		$code[] = "\n\tfunction class_title() { return ec('Объект $class_name'); }
//	function class_title_rp() { return ec('объекта $class_name'); }
//	function class_title_vp() { return ec('объект $class_name'); }
//	function class_title_m() { return ec('объекты $class_name'); }
//	function class_title_tpm() { return ec('объектами $class_name'); }

	function access_name() { return '$items_name'; }\n";

		$code[] = "\tfunction table_fields()\n\t{\n\t\treturn array(";

		$fields = array();
		foreach(explode("\n", $x['Create Table']) as $s)
		{
			// FOREIGN KEY (`head_id`) REFERENCES `persons` (`id`)
			if(preg_match('/FOREIGN KEY \(`(\w+)`\) REFERENCES `(\w+)` \(`id`\)/', $s, $mm))
			{
				$fields[$mm[1]]['class'] = "'{$project}_".bors_unplural($mm[2])."'";
				$fields[$mm[1]]['have_null'] = "true";
				continue;
			}

			if(preg_match('/^\s+`(\w+)`(.*)$/', $s, $m))
			{
				$field = $m[1];
				$type = trim($m[2]);
				if(preg_match('/^(\w+)/', $type, $mm))
					$type = $mm[1];

				$args = array();

				if(preg_match("/COMMENT '(.+?)'/", $s, $mm))
					$args['title'] = "'".addslashes($mm[1])."'";

				switch($type)
				{
					case 'timestamp':
						$args['name'] = "'UNIX_TIMESTAMP(`$field`)'";
						break;
					case 'text':
						$args['type'] = "'bbcode'";
						break;
					default:
						$append = '';
						break;
				}

				if(empty($fields[$field]))
					$fields[$field] = array();

				$fields[$field] = array_merge($fields[$field], $args);
			}
		}

		if(array_key_exists('id', $fields)
			&& array_key_exists('create_time', $fields)
			&& array_key_exists('modify_time', $fields)
			&& array_key_exists('last_editor_id', $fields)
			&& array_key_exists('owner_id', $fields)
		)
			unset($fields['id'], $fields['create_time'], $fields['modify_time'], $fields['last_editor_id'], $fields['owner_id']);

		foreach($fields as $field => $args)
		{
			$append = '';
			if(!empty($args))
			{
				foreach($args as $k => $v)
				{
					if($append)
						$append .= ', ';
					$append .= "'$k' => $v";
				}
				$code[] = "\t\t\t'{$field}' => array($append),";
			}
			else
				$code[] = "\t\t\t'{$field}'$append,";
		}

		$code[] = "\t\t);";
		$code[] = "\t}";

		$code[] = "\n\tfunction url(\$page=NULL) { return config('main_site_url').'/$items_name/'.\$this->id().'/'; }";
		$code[] = "\n\tfunction admin_url() { return config('admin_site_url').'/$items_name/'.\$this->id().'/'; }";

		$code[] = "}\n";

		$file = $item_name.'.php';
//		$n = 2;
//		while(file_exists($file))
//			$file = $item_name.($n++).'.php';

		file_put_contents($file, join("\n", $code), FILE_APPEND);

		blib_cli::out("%CClass wrote to $file%C%n\n");
	}
}
