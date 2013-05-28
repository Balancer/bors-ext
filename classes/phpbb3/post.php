<?php

class phpbb3_post extends bors_object_db
{
	function storage_engine() { return 'bors_storage_mysql'; }
	function db_name() { return 'AB_WEBAPPS_PHPBB3'; }
	function table_name() { return 'phpbb_posts'; }

	function class_title() { return ec('Сообщение'); }

	function table_fields()
	{
		return array(
			'id' => 'post_id',
			'topic_id',
			'forum_id',
			'poster_id',
			'icon_id',
			'poster_ip',
			'create_time' => 'post_time',
			'post_approved',
			'post_reported',
			'enable_bbcode',
			'enable_smilies',
			'enable_magic_url',
			'enable_sig',
			'post_username',
			'title' => 'post_subject',
			'post_text',
			'post_checksum',
			'post_attachment',
			'bbcode_bitfield',
			'bbcode_uid',
			'post_postcount',
			'post_edit_time',
			'post_edit_reason',
			'post_edit_user',
			'post_edit_count',
			'post_edit_locked',
			'post_wpu_xpost_parent',
			'post_wpu_xpost_meta1',
			'post_wpu_xpost_meta2',
		);
	}
}
