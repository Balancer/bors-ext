<?php

//TODO: добавить проверку на доступ. Админка, всё же!
class bors_ajax_actionmod_admin_children_pages extends bors_ajax_actionmod
{
	function action_up($args)
	{
		extract($args);
		$object = bors_load_uri($object);
		$text = $object->get($property);
		$text = blib_text_lines::move_up($text, $line);
		$object->set($property, $text);
		$object->store();

		return false;
	}

	function action_down($args)
	{
		extract($args);
		$object = bors_load_uri($object);
		$text = $object->get($property);
		$text = blib_text_lines::move_down($text, $line);
		$object->set($property, $text);
		$object->store();

		return false;
	}
}
