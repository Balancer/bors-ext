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
		//TODO: при человечской замене проверить на http://www.aviaport.ru/users/forget_password/
		return bors_new('aviaport_user_haction', array(
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

	function clean()
	{
		//TODO: при человеческом исправлении проверять на http://www.aviaport.ru/users/forget_password/
		bors_delete('aviaport_user_haction', array(
			'actor_class_name' => $this->actor_class_name(),
			'actor_target_id' => $this->actor_target_id(),
//			'actor_method' => $this->actor_method(),
			'limit' => false,
		));
	}
}
