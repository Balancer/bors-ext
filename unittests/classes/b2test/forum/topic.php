<?php

class b2test_forum_topic extends b2_models_db
{
	var $storage_engine = 'b2_storages_sqlite';
	var $db_name = './forum.sqlite';

	function url_ex($page) { return '/forum/topics/'.$this->id().'/'; }

	function __unit_test00($suite)
	{
		$topic = bors_new(__CLASS__, array(
			'title' => 'Test',
		));
		$suite->assertNotNull($topic);
	}
}
