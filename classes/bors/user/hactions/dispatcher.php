<?php

class bors_user_hactions_dispatcher extends base_object
{
	function pre_parse()
	{
		//TODO: при человеческом исправлении проверять на http://www.aviaport.ru/users/forget_password/
		$haction = bors_find_first('aviaport_user_haction', array('id' => $this->id()));
		if(!$haction)
			return bors_message(ec('Извините, но выбранное Вами действие невозможно. Неверная, уже использованная или устаревшая ссылка.'));

		if($haction->expire_time() < time())
			return bors_message(ec('Извините, выбранное Вами действие невозможно. Устаревшая ссылка.'));

		$actor = bors_load($haction->actor_class_name(), $haction->actor_target_id());

		$haction->set_attr('need_save', false);
		if($method = $haction->actor_method())
		{
			if($actor->$method($haction->actor_attributes(), $haction) === true)
				$ret = true;
		}
		else
			$ret = go($actor->url());

		if(!$haction->attr('need_save'))
			$haction->clean();

		return $ret;
	}
}
