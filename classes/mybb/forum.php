<?php

class mybb_forum extends bors_object_db
{
	function storage_engine() { return 'bors_storage_mysql'; }
	function db_name() { return config('mybb.db'); }
	function table_name() { return 'mybb_forums'; }

	function class_title() { return ec('Форум'); }

	function table_fields()
	{
		return array(
			'id' => 'fid',
			'title' => 'name',
			'description' => array('type' => 'bbcode'),
			'linkto',
			'type', // 'f' = форум, 'c' = категория
			'parent_forum_id' => 'pid',
			'parentlist' => array('type' => 'bbcode'),
			'sort_order' => 'disporder',
			'active',
			'open',
			'threads',
			'posts',
			'last_post_time' => 'lastpost',
			'last_poster_title' => 'lastposter',
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

	function auto_objects()
	{
		return array_merge(parent::auto_objects(), array(
			'parent_forum' => 'mybb_forum(parent_forum_id)',
		));
	}

	function update_parent_list()
	{
		if(!$this->parent_forum_id())
			return $this->id();

		$parent_list = $this->parent_forum()->update_parent_list().','.$this->id();
		$this->set_parentlist($parent_list);
		return $parent_list;
	}
}
