<?php

class exsiblo_blog extends bors_object_sqlite
{
	function table_fields()
	{
		return array(
			'id',
			'title',
			'source' => array('type' => 'bbcode'),
			'create_time' => array('type' => 'timestamp'),
		);
	}

	function html() { return lcml_bbh($this->source()); }
}
