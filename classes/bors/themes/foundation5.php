<?php

class bors_themes_foundation5 extends bors_object
{
	function render_class() { return 'self'; }

	function render($object)
	{
		$object->set_attr('layout_class', 'bors_layouts_foundation5');

		return bors_templaters_php::fetch(__DIR__.'/foundation5.tpl.php', array_merge(array('self' => $object), $object->page_data()));
	}
}
