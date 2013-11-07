<?php

class mybb_thread extends bors_object_db
{
	function storage_engine() { return 'bors_storage_mysql'; }
	function db_name() { return config('mybb.db'); }
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
			'first_poster_name' => 'username',
			'create_time' => 'dateline',
			'first_post_id' => 'firstpost',
			'lst_post_time' => 'lastpost',
			'last_poster_name' => 'lastposter',
			'last_poster_id' => 'lastposteruid',
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
