<?php

class bors_tests_object_db6_unittest extends PHPUnit_Framework_TestCase
{
	public function testObject()
	{
		if(config('phpunit.skip_db'))
			return;

		$class = 'bors_tests_object_db6';
		$object = bors_load($class, -12345);
        $this->assertNull($object);
		$object = object_new_instance($class, array(
			'id' => '123',
			'title' => 'test',
		));
		$object->store();
        $this->assertNotNull($object);

		$first = bors_find_first($class, array('title' => 'test'));
        $this->assertNotNull($first);
        $this->assertEquals('123', $first->id());
		$time = '123456789';
        $first->set_create_time($time, true);
        $first->store();

		$object = bors_find_first($class, array('create_time' => $time));
        $this->assertNotNull($object);
        $this->assertEquals('123', $object->id());

        $this->assertEquals('real_id_field', $object->id_field());
        $this->assertEquals('real_title_field', $object->title_field());
        $this->assertEquals('test_object_db6s', $object->table_name());

		// Тестим юникод
		$object = bors_new($class, array(
			'id' => '456',
			'title' => ($pattern = ec('Ещё раз…')),
		));

		$object = bors_find_first($class, array('title' => $pattern));
        $this->assertNotNull($object);

		// Проверим чтение всех объектов. Выше создавалось два
		$objects = bors_find_all($class, array('order' => '-id'));
        $this->assertEquals(2, count($objects));
        $this->assertEquals(456, $objects[0]->id());

        $this->assertEquals(date('Y'), $objects[0]->ctime2()->date('Y'));
    }

	public function setUp()
	{
		if(config('phpunit.skip_db'))
			return;

		$storage = bors_foo('bors_tests_object_db6')->storage();
		$storage->drop_table('bors_tests_object_db6');
		$storage->create_table('bors_tests_object_db6');
	}
}
