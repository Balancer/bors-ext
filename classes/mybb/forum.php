<?php

class mybb_forum extends bors_object_db
{
	function storage_engine() { return 'bors_storage_mysql'; }
	function db_name() { return 'WEBAPPS_MYBB'; }
	function table_name() { return 'mybb_forums'; }

	function class_title() { return ec('Форум'); }

	function table_fields()
	{
		return array(
			'id' => 'fid',
			'title' => 'name',
			'description' => array('type' => 'bbcode'),
			'linkto',
			'type',
			'parent_forum_id' => 'pid',
			'parentlist' => array('type' => 'bbcode'),
			'sort_order' => 'disporder',
			'active',
			'open',
			'threads',
			'posts',
			'lastpost',
			'lastposter',
			'lastposteruid',
			'lastposttid',
			'lastpostsubject',
			'allowhtml',
			'allowmycode',
			'allowsmilies',
			'allowimgcode',
			'allowvideocode',
			'allowpicons',
			'allowtratings',
			'status',
			'usepostcounts',
			'password',
			'showinjump',
			'modposts',
			'modthreads',
			'mod_edit_posts',
			'modattachments',
			'style',
			'overridestyle',
			'rulestype',
			'rulestitle',
			'rules' => array('type' => 'bbcode'),
			'unapprovedthreads',
			'unapprovedposts',
			'defaultdatecut',
			'defaultsortby',
			'defaultsortorder',
		);
	}
}
