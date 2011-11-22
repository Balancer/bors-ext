<?php

class bors_views_modules_cards extends bors_module
{
	function item_class()
	{
		$class_name = bors_unplural(str_replace('_modules_cards', '', $this->class_name()));
		return $class_name;
	}

	function item_name()
	{
		return bors_unplural(preg_replace('/^.+_(.+?)$/', '$1', $this->item_class()));
	}

	function items_name() { return bors_plural($this->item_name()); }

	function body_data()
	{
		$where = $this->arg('where', array());
		$where['order'] = $this->arg('order', defval($where, 'order', 'title'));
		$where['limit'] = $this->arg('limit', defval($where, 'limit', 10));
		$items = bors_find_all($this->item_class(), $where);
		return array_merge(parent::body_data(), array(
			$this->items_name() => $items,
			'items' => $items,
		));
	}
}
