<?php

class bors_ext_search_titles_model extends bors_object_db
{
	function table_name() { return 'titles'; }

	function table_fields()
	{
		return array(
			'id',
			'title',
			'title_norm',
			'topic_class_name',
			'topic_id',
			'forum_class_name',
			'forum_id',
			'category_class_name',
			'category_id',
			'topic_create_time' => array('name' => 'UNIX_TIMESTAMP(`topic_create_time`)'),
			'topic_modify_time' => array('name' => 'UNIX_TIMESTAMP(`topic_modify_time`)'),
			'topic_num_posts',
			'topic_post_class_name',
			'topic_first_post_id',
		);
	}
}
