<?php

class %class_name% extends %extends%
{
	function table_name() { return '%table_name%'; }
	function table_fields()
	{
		return array(
			'%from_name%_id',
			'target_class_name',
			'target_class_id',
			'target_object_id',
		);
	}
}
