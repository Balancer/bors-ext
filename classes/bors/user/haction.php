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
			'actor_attributes',
			'create_time' => 'UNIX_TIMESTAMP(`create_timestamp`)',
			'expire_time' => 'UNIX_TIMESTAMP(`expire_timestamp`)',
		);
	}

	static function add($user_id, $class_name, $method = NULL, $ttl = 8640000, $actor_attributes = NULL) // = 100 суток
	{
		$id = sha1(rand());
		return bors_new(get_called_class(), array(
			'id' => $id,
			'actor_class_name' => $class_name,
			'actor_target_id' => $user_id,
			'actor_method' => $method,
			'actor_attributes' => $actor_attributes,
			'expire_time' => time() + $ttl,
		));
	}

	function clean()
	{
		//TODO: при человеческом исправлении проверять на http://www.aviaport.ru/users/forget_password/
		bors_delete($this->class_name(), array(
			'actor_class_name' => $this->actor_class_name(),
			'actor_target_id' => $this->actor_target_id(),
//			'actor_method' => $this->actor_method(),
			'limit' => false,
		));
	}
}
