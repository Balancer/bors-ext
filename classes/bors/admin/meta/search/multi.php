<?php

// Админ-мультипоиск по нескольким классам.
// http://admin.aviaport.ru/directory/dict/search/?q=%D0%9F%D0%92%D0%9E

class bors_admin_meta_search_multi extends bors_admin_meta_main
{
	function _config_class_def() { return config('admin_config_class'); }

	function _title_def() { return ec('Общий поиск'); }
	function _nav_name_def() { return ec('общий поиск'); }

	function query()
	{
		return urldecode(bors()->request()->data('q'));
	}

	function where_m($class_name, $properties)
	{
		if(!($q = $this->query()))
			return array();

		$q = "'%".addslashes(trim($q))."%'";

		$where = array();

		$qq = array();

		foreach($properties as $p)
		{
			$x = bors_lib_orm::parse_property($class_name, $p);
			$qq[] = "`{$x['sql_name']}` LIKE {$q}";
		}

		$where[] = '('.join(' OR ', $qq).')';

		$where['limit'] = $this->args('limit', 10);

		return $where;
	}

	function items()
	{
		$result = array();
//		print_dd($this->search_classes());
		$first = true;
		foreach($this->search_classes() as $class_name => $properties)
		{
			if($first)
			{
				$this->set_main_class($class_name);
				$first = false;
			}

			if($w = $this->where_m($class_name, $properties))
			{
				if($items = bors_find_all($class_name, $w))
				{
					$item = $items[0];
					$result[$item->class_title_m()] = $items;
				}
			}
		}

		return $result;
	}

	function body_data()
	{
		// Вызываем перед parent, чтобы проинитился main_class
		$items = $this->items();
		return parent::body_data() + array(
			'search_result' => $items,
			'limit' => $this->args('limit', 10),
		);
	}

	function url($page = NULL)
	{
		$url = $this->called_url();

		if($q = $this->query())
			$url = bors_lib_urls::replace_query($url, 'q', $q);

		if($page > 1)
			$url = bors_lib_urls::replace_query($url, 'p', $page);

		return $url;
	}
}
