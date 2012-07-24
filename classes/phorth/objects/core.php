<?php

class phorth_objects_core extends phorth_objects
{
	function names()
	{
		return array(
			'new:' => 'new__column__',
		);
	}

	function new__column__($data, $stack, $forth)
	{
		$stream = $forth->input_stream();
		$class_name = $stream->next_word();
		$object = bors_new($class_name, $data);
		return $object;
	}
}
