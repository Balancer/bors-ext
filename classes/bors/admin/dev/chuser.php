<?php

class bors_admin_dev_chuser extends bors_admin_page
{
	function pre_show()
	{
		if(!config('is_developer'))
			return bors_message("Не работает в боевом режиме сайта");

		if(!($me = bors()->user()))
			return bors_message("Не авторизован");

		if(!$me->get('is_admin'))
			return bors_message("Только администраторам!");

		$user = bors_find_first('bors_user', array('login' => $this->id()));

		if(!$user)
			return bors_message("Не могу найти пользователя '{$this->id()}'");

		$user->cookies_set(3600, true);
		return go_message('Вы теперь '.$user->title(), array('go' => '/'));
	}
}
