<?php

class livestreet_user extends bors_object_db
{
	function db_name() { return 'WEBAPPS_LIVESTREET'; }
	function table_name() { return 'ls_user'; }

	function table_fields()
	{
		return array(
			'id' => 'user_id',
			'login' => 'user_login',
			'create_time' => 'UNIX_TIMESTAMP(user_date_register)',
			'activate_time' => 'UNIX_TIMESTAMP(user_date_activate)',
			'registration_ip' => 'user_ip_register',
		) + parent::table_fields();
	}
}
