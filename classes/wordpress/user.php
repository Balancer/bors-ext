<?php

class wordpress_user extends bors_object_db
{
	function storage_engine() { return 'bors_storage_mysql'; }
	function db_name() { return 'AB_WEBAPPS_WORDPRESS'; }
	function table_name() { return 'wp_users'; }

	function class_title() { return ec('Пользователь'); }

	function access_name() { return 'users'; }

	function table_fields()
	{
		return array(
			'id' => 'ID',
			'user_login',
			'user_pass',
			'user_nicename',
			'email' => 'user_email',
			'www' => 'user_url',
			'register_time' => array('name' => 'UNIX_TIMESTAMP(`user_registered`)'),
			'user_activation_key',
			'user_status',
			'display_name',
		);
	}
}
