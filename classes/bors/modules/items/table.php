<?php

class bors_modules_items_table extends bors_module
{
	function main_class()
	{
		$items = $this->args('items');
		$first = is_array($items) ? array_pop($items) : $items->pop();
		return $first->class_name();
	}

	function body_data()
	{
		$foo = bors_foo($this->main_class());

		$new_link_title = false;
		if(!$this->get('skip_auto_admin_new'))
			if(!$foo->get('skip_auto_admin_new'))
				$new_link_title = $foo->class_title_vp();

		$fields = $this->args('item_fields');
		if(!$fields)
			$fields = $this->get('item_fields');

		if(!$fields)
			$fields = $foo->item_list_admin_fields();

		$parsed_fields = array();
		$sortable = array();
		foreach($fields as $p => $t)
		{
			if(is_numeric($p))
			{
				$p = $t;
				$x = bors_lib_orm::parse_property($this->main_class(), $p);
				$t = defval($x, 'title', $p);
				if(!empty($x['admin_sortable']))
					$sortable[] = $p;
			}

			$parsed_fields[$p] = $t;
		}

		$this->set_attr('_sortable_append', $sortable);

		return array_merge(parent::body_data(), array(
			'new_link_title' => $new_link_title,
			'item_fields' => $parsed_fields,
			'admin_search_url' => $this->page() > 1 ? false : $this->get('admin_search_url'),
			'table_css' => $this->args('table_css', 'bors_modules_items_table'),
		));
	}

	function make_sortable_th($property, $title)
	{
		$sorts = $this->get('sortable', array());
		if($x = $this->get('_sortable_append', array()))
			$sorts = array_merge($x, $sorts);

		$parsed_sorts = array();

		foreach($sorts as $f => $p)
		{
			if(is_numeric($f))
			{
				$f = $p;
				$x = bors_lib_orm::parse_property($this->main_class(), $f);
				$t = defval($x, 'title', $f);
			}

			$parsed_sorts[$f] = $p;
		}

		$sorts = $parsed_sorts;

		if(!($sort_key = @$sorts[$property]))
			return "<th>$title</th>";

		$current_sort = bors()->request()->data_parse('signed_names', 'sort');
		if(preg_match('/^(.+)\*$/', $sort_key, $m))
		{
			$sort_key = $m[1];
			$is_default = true;
		}
		else
			$is_default = false;

		if($is_default && !$current_sort)
			$current_sort = $sort_key;

		$sort = bors_lib_orm::reverse_sign($sort_key, $current_sort);

		$sign = bors_lib_orm::property_sign($sort);
		if($is_default && $sort_key == $sort)
			$sort = NULL;

		$url = bors()->request()->url();

		$url = bors_lib_urls::replace_query($url, 'sort', $sort);

		bors_lib_orm::property_sign($current_sort, true);
		bors_lib_orm::property_sign($sort_key, true);
		if($current_sort != $sort_key)
			$sort_class = 'sort_ascdesc';
		else
			$sort_class = $sign == '-' ? 'sort_asc' : 'sort_desc';

		return "<th class=\"$sort_class\"><a href=\"{$url}\">$title</a></th>";
	}
}
