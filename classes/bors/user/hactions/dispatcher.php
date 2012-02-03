<?php

class bors_user_hactions_dispatcher extends base_object
{
	function pre_parse()
	{
		$action = bors_find_first('bors_user_haction', array('id' => $this->id()));
		if(!$action)
			return bors_message(ec('Извините, но выбранное Вами действие невозможно. Неверная или очень устаревшая ссылка.'));

		if($action->expire_time() < time())
			return bors_message(ec('Извините, выбранное Вами действие невозможно. Устаревшая ссылка.'));

		$actor = bors_load($action->actor_class_name(), $action->actor_target_id());

		if($method = $action->actor_method())
		{
			if($actor->$method($this) === true)
				return true;
		}
		else
		{
			$this->clean();
			return go($actor->url());
		}

		bors_function_include('debug/hidden_log');
		debug_hidden_log('error-haction', "Unknown error for ".$this->id());
		return bors_message(ec('Извините, возникла ошибка обработки Вашего запроса. Ошибка зафиксирована в системном журнале и её внимательно изучат наши администраторы.'));
	}

	function clean()
	{
		bors_delete('bors_user_haction', array(
			'actor_class_name' => $this->actor_class_name(),
			'actor_target_id' => $this->actor_target_id(),
//			'actor_method' => $this->actor_method(),
			'limit' => false,
		));
	}
}
