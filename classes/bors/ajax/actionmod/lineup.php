<?php

class bors_ajax_actionmod_lineup extends bors_ajax_actionmod
{
	function action($args)
	{
		extract($args);
		$text = $object->get($property);
		$text = blib_text_lines::move_up($text, $line);
		$object->set($property, $text);
		$object->store();
	}
}
