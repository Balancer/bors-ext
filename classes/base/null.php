<?php

// Legacy
class base_null extends bors_object_empty
{
	static function __unit_test($suite)
	{
		$object = bors_load('base_null', NULL);
		$suite->assertNotNull($object);
		$suite->assertNull($object->id());
		$suite->assertEquals('base_null', $object->class_name());
	}
}
