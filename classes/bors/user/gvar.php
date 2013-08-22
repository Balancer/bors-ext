<?php

class bors_user_gvar extends bors_object_db
{
	function table_name() { return 'user_guest_vars'; }
	function table_fields()
	{
		return array(
			'id' => 'cookie_hash',
			'var_name',
			'var_value',
			'create_time' => 'UNIX_TIMESTAMP(`create_ts`)',
		);
	}

	function replace_on_new_instance() { return true; }
}
