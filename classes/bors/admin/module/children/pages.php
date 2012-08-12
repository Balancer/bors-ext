<?php

class bors_admin_module_children_pages extends bors_module
{
	function body_data()
	{
		$target = $this->arg('object', bors()->main_object());
		if(!$target)
			bors_throw(ec('Попытка вызвать модуль связей для несуществующего объекта.'));

		$children = $target->child_objects();
		$append_class = $this->arg('append_class');

		return array_merge(parent::body_data(), array(
			'target' => $target,
			'children' => $children,
			'append_class' => $append_class,
			'append_foo' => $append_class ? new $append_class(NULL) : NULL,
			'target_path' => blib_urls::path($target->url()),
		));
	}
}
