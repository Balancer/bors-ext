<?php

set_def($_SERVER, 'HTTP_HOST', 'ls.balancer.ru');
set_def($_SERVER, 'REMOTE_ADDR', '');

require_once("/data/var/www/ru/balancer/ls.balancer.ru/htdocs/config/loader.php");
require_once(Config::Get('path.root.engine')."/classes/Engine.class.php");

require_once(Config::Get('path.root.engine').'/lib/external/DklabCache/config.php');
require_once(LS_DKCACHE_PATH.'Zend/Cache.php');
require_once(LS_DKCACHE_PATH.'Cache/Backend/MemcachedMultiload.php');
require_once(LS_DKCACHE_PATH.'Cache/Backend/TagEmuWrapper.php');
require_once(LS_DKCACHE_PATH.'Cache/Backend/Profiler.php');

class livestreet_native_user
{
	function bb_copy($user, $password)
	{
		$engine = Engine::getInstance();
		$action = new ActionRegistration($engine, NULL);

		$user_id = $user->id();
		if($user_id == 10000)
			$user_id = 1;

		if(!bors_load('livestreet_user', $user_id))
		{
			bors_new('livestreet_user', array(
				'id' => $user_id,
				'login' => $user->login(),
				'create_time' => $user->create_time(),
				'activate_time' => time(),
				'registration_ip' => $user->registration_ip(),
			));
			bors()->changed_save();
		}

		$ls_user = $action->User_GetUserById($user_id);

		$ls_user->setPassword(func_encrypt($password));
		$ls_user->setLogin($user->login());
		$ls_user->setMail($user->email());
		$ls_user->setProfileName($user->title());
		$ls_user->setProfileSite($user->www());
		$ls_user->setProfileIcq($user->icq());
		if($ava = $user->use_avatar())
			$ls_user->setProfileAvatar('http://balancer.ru/forum/punbb/img/avatars/'.$ava);

		$ls_user->setActivate(1);
		$ls_user->setActivateKey(null);

		$action->User_Update($ls_user);

		$action->Blog_CreatePersonalBlog($ls_user);

//		$action->Notify_SendRegistration($ls_user,getRequest('password'));
		$action->Viewer_Assign('bRefreshToHome',true);
		$action->User_Authorization($ls_user, false);
	}
}
