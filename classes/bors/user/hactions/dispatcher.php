<?php

class bors_user_hactions_dispatcher extends base_object
{
	function pre_parse()
	{
		//TODO: при человеческом исправлении проверять на http://www.aviaport.ru/users/forget_password/
		$action = bors_find_first('aviaport_user_haction', array('id' => $this->id()));
		if(!$action)
			return bors_message(ec('Извините, но выбранное Вами действие невозможно. Неверная, уже использованная или устаревшая ссылка.'));

		if($action->expire_time() < time())
			return bors_message(ec('Извините, выбранное Вами действие невозможно. Устаревшая ссылка.'));

		$actor = bors_load($action->actor_class_name(), $action->actor_target_id());

		if($method = $action->actor_method())
		{
			if($actor->$method($action, $this) === true)
				return true;
		}
		else
		{
//			$this->clean();
			return go($actor->url());
		}

		bors_function_include('debug/hidden_log');
		debug_hidden_log('error-haction', "Unknown error for ".$this->id());
		return bors_message(ec('Извините, возникла ошибка обработки Вашего запроса. Ошибка зафиксирована в системном журнале и её внимательно изучат наши администраторы.'));
	}
}
