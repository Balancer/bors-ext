<?php

class bors_page_meta_search extends bors_page_meta_main
{
	function title() { return ec('Поиск по ').$this->foo_object()->class_title_dpm(); }
	function nav_name() { return ec('поиск'); }
	function auto_map() { return true; }

	function _main_class_def() { bors_throw(ec('Не определён класс для поиска')); }

	function q() { return trim(urldecode(@$_GET['q'])); }
	function qfc()
	{
		$fc = trim(urldecode(@$_GET['fc']));

		if(strlen($fc) == 2)
			$fc = ec($fc);

		return $fc;
	}

	function pre_parse()
	{
		if(!$this->qfc() && !$this->q())
		{
			$parents = $this->parents();
			return go(empty($parents[0]) ? '/' : $parents[0]);
		}

		return parent::pre_parse();
	}

	function pre_show()
	{
		template_noindex();

		$items = $this->items();

		if(sizeof($items) == 1 && $this->total_items() == 1)
			return go($items[0]->url());

		return false;
	}

	function body_data()
	{
		$data = parent::body_data();

		if(!$this->q() && !$this->qfc())
			return $data;

		$data['items'] = bors_find_all($this->main_class(), array(
			'where' => $this->where(),
			'page' => $this->page(),
			'per_page' => $this->items_per_page(),
			'order' => $this->order()));

		$data['query'] = $this->q();

		$main_class = $this->main_class();
		$foo = new $main_class(NULL);


		$fields = $this->get('item_fields');
		if(!$fields)
			$fields = bors_lib_object::get_foo($this->main_class(), 'item_list_fields');

		$data['item_fields'] = $fields;

		return $data;
	}

	function _order_def() { return 'title'; }


	function total_items()
	{
		return bors_count($this->main_class(), array('where' => $this->where()));
	}

	function where()
	{
		if(!$this->q() && !$this->qfc())
			return array();

		$q = $qfc = NULL;

		if($this->q())
			$q = "'%".addslashes($this->q())."%'";

		if($this->qfc())
			$qfc = "'".addslashes($this->qfc())."%'";

		$any = @$_GET['w'] == 'a';

		$qq = array();

		$main_class = $this->main_class();
		$foo = new $main_class(NULL);

		if($qfc)
			$properties = $foo->get('searchable_alpha_properties', array());

		if(empty($properties))
			$properties = $foo->get('searchable_title_properties', array());

		$all_properties   = $foo->get('searchable_properties', array());

		if(!is_array($properties))
			$properties = explode(' ', $properties);

		if(!is_array($all_properties))
			$all_properties = explode(' ', $all_properties);

		if($any)
			$properties += $all_properties;

		if(!$properties)
			bors_throw("Не указаны поля для поиска (searchable_title_properties)");

		foreach($properties as $p)
		{
			if(strpos($p, '`') === false)
			{
				$x = bors_lib_orm::parse_property($this->main_class(), $p);

				if(!$x || !$x['name'])
				{
					debug_hidden_log('search_properties_error', "Unknown property $p");
					continue;
				}

				$field = "`{$x['name']}`";
			}
			else
				$field = $p;
//			var_dump($this->main_class(), $p, $field);
			if($q)
				$qq[] = "$field LIKE {$q}";
			if($qfc)
				$qq[] = "$field LIKE {$qfc}";
		}

		$where = array('('.join(' OR ', $qq).')');
//		var_dump($where);
		return $where;
	}
}
