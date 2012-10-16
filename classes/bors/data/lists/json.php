<?php

class bors_data_lists_json extends bors_json
{
	function can_read() { return bors_lib_object::get_foo($this->id(), 'can_read'); }
	function access() { return bors_lib_object::get_foo($this->id(), 'access'); }

	function data()
	{
//		file_put_contents('/tmp/json.log', print_r($_SERVER, true), FILE_APPEND);

		$list_class_name = $this->id();

//	q=Шере&p=1&s=10&contentType=application/json; charset=utf-8

		$find = bors_find($list_class_name);

		if($q = bors()->request()->data('q'))
			$find->like('title', $q);

//			file_put_contents('/tmp/json.log', $q, FILE_APPEND);

		$total = $find->count();

		if($p = bors()->request()->data('p'))
			$find->page($p, bors()->request()->data('s'));

		$find->order('title');

		$result = array();
		foreach($find->all() as $x)
			$result[] = array('id' => $x->id(), 'name' => $x->title());

		return array('results' => $result, 'total' => $total);
	}
}
