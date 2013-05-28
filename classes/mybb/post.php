<?php

class mybb_post extends bors_object_db
{
	function storage_engine() { return 'bors_storage_mysql'; }
	function db_name() { return 'WEBAPPS_MYBB'; }
	function table_name() { return 'mybb_posts'; }

	function class_title() { return ec('Сообщение'); }

	function table_fields()
	{
		return array(
			'id' => 'pid',
			'topic_id' => 'tid',
			'replyto',
			'forum_id' => 'fid',
			'title' => 'subject',
			'icon',
			'owner_id' => 'uid',
			'owner_name' => 'username',
			'create_time' => 'dateline',
			'source' => 'message',
			'ipaddress',
			'longipaddress',
			'includesig',
			'smilieoff',
			'edituid',
			'edittime',
			'is_visible' => 'visible',
			'posthash',
		);
	}
}
