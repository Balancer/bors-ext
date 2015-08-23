<?php

/**
	Управление списками привязанных объектов
	Пример: http://admin.aviaport.wrk.ru/directory/airlines/266/airports/
*/

class bors_admin_meta_xref extends bors_admin_page
{
//	function can_action($action, $data) { return $this->xref_target_foo_object()->can_action(NULL, NULL); }
	function access() { return $this->xref_foo_object()->access(); }

	function body_template_ext()
	{
		$type = $this->get('admin_page_type');
		if($type)
			return $type.'.html';

		if($this->get('object_target_swap'))
			return 'swap.html';

		return parent::body_template_ext();
	}

	function body_data()
	{
		$additional = array();
		foreach($this->xref_foo_object()->get('additional_properties') as $p)
		{
			$x = bors_lib_orm::parse_property($this->xref_class_name(), $p);
//			var_dump($p, $x);
			$additional[] = $x;
		}

//		var_dump($this->xref_class_name(), $this->xref_foo_object()->object_field_name(), $this->id());

		if($this->get('object_target_swap'))
			$xref_list = bors_find(
				$this->xref_class_name())
					->where($this->xref_foo_object()->target_field_name(),	$this->id())
					->all();
		else
			$xref_list = bors_find(
				$this->xref_class_name())
					->where($this->xref_foo_object()->object_field_name(),	$this->id())
					->all();

		return array(
			'targets_list' => bors_find($this->xref_target_class_name())->all(),
			'json' => $this->get('object_target_swap') ?
				'/_bors/data/lists/'.$this->xref_object_class_name().'.json'
					: '/_bors/data/lists/'.$this->xref_target_class_name().'.json',
			'xref_list' => $xref_list,
			'additional' => $additional,
		) + parent::body_data();
	}

	function xref_foo_object()
	{
		$class_name = $this->xref_class_name();
		return new $class_name(NULL);
	}

	function xref_object_class_name()
	{
		return $this->xref_foo_object()->object_class_name();
	}

	function xref_object_foo_object()
	{
		$target_class_name = $this->xref_object_class_name();
		return new $target_class_name(NULL);
	}

	function xref_target_class_name()
	{
		return $this->xref_foo_object()->target_class_name();
	}

	function xref_target_foo_object()
	{
		$target_class_name = $this->xref_target_class_name();
		return new $target_class_name(NULL);
	}

	function on_action_add($data)
	{
//		var_dump($data); exit();
		$class_name = $this->xref_class_name();

		if($this->get('object_target_swap'))
			$class_name::add(
				$data['xref_id'],
				$this->id(),
				$data
			);
		else
			$class_name::add(
				$this->id(),
				$data['xref_id'],
				$data
			);

		return go($data['uri']);
	}

	function on_action_unlink($data)
	{
		$xref = bors_load_uri($data['target']);
		$xref->delete();
		return go($data['ref']);
	}

	function xref_ids()
	{
		$class_name = $this->xref_class_name();
		$foo = bors_foo($class_name);
		return $foo->target_ids(array($foo->object_field_name() => $this->id()));
	}

	function on_action_save($data)
	{
		$class_name = $this->xref_class_name();
		$foo = bors_foo($class_name);
		$object_field = $foo->object_field_name();
		$target_field = $foo->target_field_name();

//		var_dump($data, $target_field);

		$object_id = $data['object_id'];

		if(!$object_id)
			return go($data['uri']);

		foreach(bors_find_all($class_name, array($object_field => $object_id)) as $xref)
			if(!empty($data['xref_ids']) && !in_array($xref->get($target_field), $data['xref_ids']))
				$xref->delete();

		if(!empty($data['xref_ids']))
		{
			foreach($data['xref_ids'] as $target_id)
				$class_name::add(
					$this->id(),
					$target_id,
					$data
				);
		}

		return go($data['uri']);
	}
}
