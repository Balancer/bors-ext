<?php

// Мультипоиск по нескольким классам.

class bors_meta_search_multi extends bors_smart_page
{
	function _title_def() { return ec('Общий поиск'); }
	function _nav_name_def() { return ec('общий поиск'); }

	function query()
	{
		return urldecode(bors()->request()->data('q'));
	}

	function where($class_name)
	{
		if(!($q = $this->query()))
			return array();

		$q = "'%".addslashes(trim($q))."%'";

		$where = array();

		$qq = array();
		$properties = explode(' ', bors_lib_object::get_foo($class_name, 'admin_searchable_properties'));

		foreach($properties as $p)
		{
			bors_lib_orm::field($class_name, $p);
			$qq[] = "`{$p['name']}` LIKE {$q}";
		}

		$where[] = '('.join(' OR ', $qq).')';

		$where['limit'] = $this->args('limit', 10);

		return $where;
	}

	function body_data()
	{
		$result = array();
//		print_dd($this->search_classes());
		foreach($this->search_classes() as $class_name)
		{
			if($w = $this->where($class_name))
			{
				if($items = bors_find_all($class_name, $w))
				{
					$item = $items[0];
					$result[$item->class_title_m()] = $items;
				}
			}
		}

		return parent::body_data() + array(
			'search_result' => $result,
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
