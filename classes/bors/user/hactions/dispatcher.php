<?php

class bors_user_hactions_dispatcher extends bors_object
{
	function pre_parse()
	{
		//TODO: при человеческом исправлении проверять на http://www.aviaport.ru/users/forget_password/
		$haction = bors_find_first('bors_user_haction', array('id' => $this->id()));
		if(!$haction)
			return bors_message(ec('Извините, но выбранное Вами действие невозможно. Неверная, уже использованная или устаревшая ссылка.'));

		// Криво, но нам нужен оригинальный объект, так что перезагружаем уже с нужным:
		$haction = bors_find_first($haction->haction_class_name(), array('id' => $this->id()));

		if(!$haction)
			return bors_message(ec('Извините, выбранное Вами действие невозможно. Это действие устарело.'));

		if($haction->expire_time() < time())
			return bors_message(ec('Извините, выбранное Вами действие невозможно. Устаревшая ссылка.'));

		$actor = bors_load($haction->actor_class_name(), $haction->actor_target_id());

		$haction->set_attr('need_save', false);

		if($method = $haction->actor_method())
		{
			if(!preg_match('/^haction_/', $method))
				$method = 'haction_'.$method;

			if(!$actor)
				bors_throw("Incorrect h-action class '{$haction->actor_class_name()}({$haction->actor_target_id()})'");

			$ret = $actor->$method(json_decode($haction->actor_attributes(), true), $haction);
		}
		else
			$ret = $actor->url();

		// Выше ставили атрибут. Если не переустанавливался, то зачищаем.
		if(!$haction->attr('need_save'))
			$haction->clean();

		if($ret === true)
			return true;

		return go($ret);
	}
}
