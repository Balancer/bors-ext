<?php

/**
	Управление списками привязанных объектов
	Пример: http://admin.aviaport.wrk.ru/directory/airlines/266/airports/
*/

class bors_admin_meta_xref extends bors_admin_page
{
	function body_data()
	{
		return array(
			'targets_list' => bors_find($this->xref_target_class_name())->all(),
			'xref_list' => bors_find(
					$this->xref_class_name())->where($this->xref_foo_object()->object_field_name(),
				$this->id())->all(),
		) + parent::body_data();
	}

	function xref_foo_object()
	{
		$class_name = $this->xref_class_name();
		return new $class_name(NULL);
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
		$class_name = $this->xref_class_name();

		$class_name::add(
			$this->id(),
			$data['xref_id']
		);

		return go($data['uri']);
	}

	function on_action_unlink($data)
	{
		$xref = bors_load_uri($data['target']);
		$xref->delete();
		return go($data['ref']);
	}
}
