<?php

class bors_admin_dev_chuser extends bors_page
{
	function access() { return $this; }
	function can_read() { return true; }
	function url() { return $this->called_url(); }

	function pre_show()
	{
		if(!config('is_developer'))
			return bors_message("Не работает в боевом режиме сайта");

		if(!($me = bors()->user()))
			return bors_message("Не авторизован");

		if(!$me->get('is_admin'))
			return bors_message("Только администраторам!");

		$id = $this->id();
		$user = bors_find_first('bors_user', array('login' => $id));

		if(!$user && is_numeric($id))
			$user = bors_load('bors_user', $id);

		if(!$user)
			return bors_message("Не могу найти пользователя '{$this->id()}'");

		$user->cookies_set(3600, true);
//		exit('You are '.$user);
		return go_message('Вы теперь '.$user->title(), array('go' => '/'));
	}
}
