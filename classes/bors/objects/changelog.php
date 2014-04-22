<?php

class bors_objects_changelog extends bors_object_db
{
	function table_name() { return 'bors_changes_log'; }

	function table_fields()
	{
		return array(
			'id',
			'property_name',
			'create_time' => array('name' => 'UNIX_TIMESTAMP(`create_ts`)'),
			'old_value',
			'target_class_name',
			'target_id',
			'last_editor_id',
			'last_editor_ip',
		);
	}

	static function add($object)
	{
		foreach($object->changed_fields as $property_name => $old_value)
		{
			bors_new('bors_objects_changelog', array(
				'property_name' => $property_name,
				'old_value' => $old_value,
				'target_class_name' => $object->class_name(),
				'target_id' => $object->id(),
			));
		}
	}
}
