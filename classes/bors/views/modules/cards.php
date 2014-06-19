<?php

class bors_views_modules_cards extends bors_module
{
	function item_class()
	{
		$class_name = blib_grammar::singular(str_replace('_modules_cards', '', $this->class_name()));
		return $class_name;
	}

	function item_name()
	{
		return blib_grammar::singular(preg_replace('/^.+_(.+?)$/', '$1', $this->item_class()));
	}

	function items_name() { return bors_plural($this->item_name()); }

	function body_data()
	{
		$where = $this->arg('where', array());
		$where['order'] = $this->arg('order', defval($where, 'order', '-create_time'));
		$where['limit'] = $this->arg('limit', defval($where, 'limit', 10));

		if($this->args('owned_only'))
			$where['owner_id'] = bors()->user_id();

		$items = bors_find_all($this->item_class(), $where);
		return array_merge(parent::body_data(), array(
			$this->items_name() => $items,
			'items' => $items,
		));
	}

	function new_titled_link()
	{
		$class_name = $this->item_class();
		$foo = new $class_name(NULL);

		$x = array(
			'f' => ec('ая'),
			'm' => ec('ый'),
			'n' => ec('ое'),
		);

		$title = ec('Нов').$x[$foo->class_title_gender()].' '.bors_lower($foo->class_title());

		return "<a href=\"{$foo->admin()->urls('new')}\">$title</a>";
	}
}
