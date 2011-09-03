<?php

class bors_tests_object_db5_unittest extends PHPUnit_Framework_TestCase
{
    public function testObject()
    {
		$object = object_load('bors_tests_object_db5', -12345);
        $this->assertNull($object);
		$object = object_new_instance('bors_tests_object_db5', array(
			'id' => '123',
			'title' => 'test',
		));
		$object->store();
        $this->assertNotNull($object);

		$first = objects_first('bors_tests_object_db5', array('title' => 'test'));
        $this->assertNotNull($first);
        $this->assertEquals('123', $first->id());
		$time = '123456789';
        $first->set_create_time($time, true);
        $first->store();

		$object = objects_first('bors_tests_object_db5', array('create_time' => $time));
        $this->assertNotNull($object);
        $this->assertEquals('123', $object->id());

        $this->assertEquals('real_id_field', $object->id_field());
        $this->assertEquals('real_title_field', $object->title_field());
        $this->assertEquals('bors_tests_object_db5s', $object->table_name());
    }

	public function setUp()
	{
		$se = call_user_func(array('bors_tests_object_db5', 'storage_engine'));
		$se = object_load($se);
		$se->drop_table('bors_tests_object_db5');
		$se->create_table('bors_tests_object_db5');
	}
}
