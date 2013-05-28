<?php

class mybb_user extends bors_object_db
{
	function storage_engine() { return 'bors_storage_mysql'; }
	function db_name() { return 'WEBAPPS_MYBB'; }
	function table_name() { return 'mybb_users'; }

	function class_title() { return ec('Пользователь'); }

	function table_fields()
	{
		return array(
			'id' => 'uid',
			'login' => 'username',
			'password',
			'salt',
			'loginkey',
			'email',
			'postnum',
			'avatar',
			'avatardimensions',
			'avatartype',
			'usergroup',
			'additionalgroups',
			'displaygroup',
			'usertitle',
			'create_time' => 'regdate',
			'lastactive',
			'lastvisit',
			'lastpost',
			'www' => 'website',
			'icq',
			'aim',
			'yahoo',
			'msn',
			'birthday',
			'birthdayprivacy',
			'signature' => array('type' => 'bbcode'),
			'allownotices',
			'hideemail',
			'subscriptionmethod',
			'invisible',
			'receivepms',
			'receivefrombuddy',
			'pmnotice',
			'pmnotify',
			'threadmode',
			'showsigs',
			'showavatars',
			'showquickreply',
			'showredirect',
			'ppp',
			'tpp',
			'daysprune',
			'dateformat',
			'timeformat',
			'timezone',
			'dst',
			'dstcorrection',
			'buddylist',
			'ignorelist',
			'style',
			'away',
			'awaydate',
			'returndate',
			'awayreason',
			'pmfolders',
			'notepad' => array('type' => 'bbcode'),
			'referrer',
			'referrals',
			'reputation',
			'regip',
			'lastip',
			'longregip',
			'longlastip',
			'language',
			'timeonline',
			'showcodebuttons',
			'totalpms',
			'unreadpms',
			'warningpoints',
			'moderateposts',
			'moderationtime',
			'suspendposting',
			'suspensiontime',
			'suspendsignature',
			'suspendsigtime',
			'coppauser',
			'classicpostbit',
			'loginattempts',
			'usernotes' => array('type' => 'bbcode'),
		);
	}
}
