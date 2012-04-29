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
	static function bb_copy($user, $password = NULL, $notify = false)
	{
		$engine = Engine::getInstance();
		$action = new ActionRegistration($engine, NULL);

		$user_id = $user->id();
		if($user_id == 10000)
			$user_id = 1;

		if($prev = bors_load('livestreet_user', $user_id))
		{
			$old_pass = $prev->user_password();
		}
		else
		{
			bors_new('livestreet_user', array(
				'id' => $user_id,
				'login' => $user->login(),
				'create_time' => $user->create_time(),
				'activate_time' => time(),
				'registration_ip' => $user->registration_ip(),
			));
			bors()->changed_save();
			$old_pass = NULL;
		}

		$ls_user = $action->User_GetUserById($user_id);

		if($password)
			$ls_user->setPassword(func_encrypt($password));

		$ls_user->setLogin($user->login());
		$ls_user->setMail($user->email());
		$ls_user->setProfileName($user->title());
		$ls_user->setProfileSite($user->www());
		$ls_user->setProfileIcq($user->icq());

		$last_post = bors_find_first('balancer_board_post', array('owner_id' => $user->id(), 'order' => '-create_time'));
		if($last_post)
		{
			require_once('inc/clients/geoip-place.php');
			list($country_code, $country_name, $city) = geoip_info($last_post->poster_ip());
			if($country_name && !$ls_user->getProfileCountry())
				$ls_user->setProfileCountry($country_name);

			self::update_country($action, $ls_user);

			if($city && !$ls_user->getProfileCity())
				$ls_user->setProfileCity($city);

			self::update_city($action, $ls_user);
		}

		if($ava = $user->use_avatar())
		{
			if($fpath = self::register_avatar($action, '/var/www/balancer.ru/htdocs/forum/punbb/img/avatars/'.$ava, $ls_user))
				$ls_user->setProfileAvatar($fpath);
		}

		$ls_user->setActivate(1);
		$ls_user->setActivateKey(null);

		$action->User_Update($ls_user);

		$action->Blog_CreatePersonalBlog($ls_user);

		if($notify && $password && ($ls_user->getPassword() != $old_pass))
			$action->Notify_SendRegistration($ls_user, $password);

		$action->Viewer_Assign('bRefreshToHome',true);
		$action->User_Authorization($ls_user, false);
	}

	function register_avatar($action, $file, $ls_user)
	{
		$sFileTmp=Config::Get('sys.cache.dir').func_generator();
		if(!copy($file, $sFileTmp))
			return false;

		$sPath   = $action->Image_GetIdDir($ls_user->getId());
		$aParams = $action->Image_BuildParams('avatar');

		$oImage = new LiveImage($sFileTmp);

		if($sError=$oImage->get_last_error()) {
			@unlink($sFileTmp);
			return false;
		}

		$oImage = $action->Image_CropSquare($oImage);
		$oImage->set_jpg_quality($aParams['jpg_quality']);
		$oImage->output(null,$sFileTmp);

		if ($sFileAvatar=$action->Image_Resize($sFileTmp,$sPath,'avatar_100x100',Config::Get('view.img_max_width'),Config::Get('view.img_max_height'),100,100,false,$aParams)) {
			$aSize=Config::Get('module.user.avatar_size');
			foreach ($aSize as $iSize) {
				if ($iSize==0) {
					$action->Image_Resize($sFileTmp,$sPath,'avatar',Config::Get('view.img_max_width'),Config::Get('view.img_max_height'),null,null,false,$aParams);
				} else {
					$action->Image_Resize($sFileTmp,$sPath,"avatar_{$iSize}x{$iSize}",Config::Get('view.img_max_width'),Config::Get('view.img_max_height'),$iSize,$iSize,false,$aParams);
				}
			}
			@unlink($sFileTmp);
			return $action->Image_GetWebPath($sFileAvatar);
		}
		@unlink($sFileTmp);

		return false;
	}

	static function update_country($action, $user)
	{
		if($user->getProfileCountry())
		{
			if (!($oCountry=$action->User_GetCountryByName($user->getProfileCountry())))
			{
				$oCountry = Engine::GetEntity('User_Country');
				$oCountry->setName($user->getProfileCountry());
				$action->User_AddCountry($oCountry);
			}

			$action->User_SetCountryUser($oCountry->getId(), $user->getId());
		}
	}

	static function update_city($action, $user)
	{
		if($user->getProfileCity())
		{
			if (!($oCity=$action->User_GetCityByName($user->getProfileCity())))
			{
				$oCity = Engine::GetEntity('User_City');
				$oCity->setName($user->getProfileCity());
				$action->User_AddCity($oCity);
			}

			$action->User_SetCityUser($oCity->getId(), $user->getId());
		}
	}
}
