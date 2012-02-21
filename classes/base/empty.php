<?php

// Legacy
class base_empty extends bors_object_simple
{
	static function __unit_test($suite)
	{
		$object = bors_load('base_empty', NULL);
		$suite->assertNotNull($object);
		$suite->assertNull($object->id());
		$suite->assertEquals('base_empty', $object->class_name());
	}
}
