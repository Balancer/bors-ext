<?php

// Отработка и тесты на http://id.aviaport.wrk.ru/login

class bors_meta_login extends bors_page
{
	var $title_ec = 'Аутентификация';

	function body_data()
	{
		return array_merge(parent::body_data(), array(
			'ref' => bors()->request()->referer(),
		));
	}

	function on_action_login($data)
	{
		$ref = defval_ne($_GET, 'redirect_url');
		$ref = defval_ne($_GET, 'ref', $ref, '/');

		$ref_back = $_SERVER['REQUEST_URI'].'?ref='.$ref;

		if(empty($data['login']))
			return go_ref_message(ec("Вы не указали логин"), array('go' => $ref_back, 'error_fields' => 'login'));

		if(empty($data['password']))
			return go_ref_message(ec("Не указали пароль"), array('go' => $ref_back, 'error_fields' => 'password'));

		$me = bors_user::do_login($data['login'], $data['password'], false);

		if(!is_object($me))
		{
			if(!$me)
				$me = ec('Ошибка аутентификации');

			sleep(2);
			return go_ref_message($me, array('go' => $ref_back, 'error_fields' => 'login,password'));
		}

		return go_ref_message(ec('Вы успешно аутентифицированы, ').$me->title().'!', array('go' => $ref, 'error' => false));
	}
}
