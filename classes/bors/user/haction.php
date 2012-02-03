<?php

class bors_user_haction extends base_object_db
{
	function storage_engine() { return 'bors_storage_mysql'; }
	function table_name() { return 'user_hactions'; }

	function table_fields()
	{
		return array(
			'id',
			'actor_class_name',
			'actor_target_id',
			'actor_method',
			'create_time' => 'UNIX_TIMESTAMP(`create_timestamp`)',
			'expire_time' => 'UNIX_TIMESTAMP(`expire_timestamp`)',
		);
	}

	static function add($user_id, $class_name, $method = NULL, $ttl = 8640000) // = 100 суток
	{
		$id = sha1(rand());
		bors_new('bors_user_haction', array(
			'id' => $id,
			'actor_class_name' => $class_name,
			'actor_target_id' => $user_id,
			'actor_method' => $method,
			'expire_time' => time() + $ttl,
		));
	}

	function unsubscribe_channel_1($action)
	{
	}
}
