<?php

class mybb_thread extends bors_object_db
{
	function storage_engine() { return 'bors_storage_mysql'; }
	function db_name() { return 'WEBAPPS_MYBB'; }
	function table_name() { return 'mybb_threads'; }

	function class_title() { return ec('Тема'); }

	function table_fields()
	{
		return array(
			'id' => 'tid',
			'forum_id' => 'fid',
			'title' => 'subject',
			'prefix',
			'icon',
			'poll',
			'uid',
			'username',
			'dateline',
			'firstpost',
			'lastpost',
			'lastposter',
			'lastposteruid',
			'views',
			'replies',
			'closed',
			'sticky',
			'numratings',
			'totalratings',
			'notes' => array('type' => 'bbcode'),
			'is_visible' => 'visible',
			'unapprovedposts',
			'attachmentcount',
			'deletetime',
		);
	}
}
