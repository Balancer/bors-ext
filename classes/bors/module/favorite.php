<?php

class bors_module_favorite extends bors_module
{
	function form_html()
	{
		$target = $this->args('target');
		$me = bors()->user();
		$exists = bors_user_favorite::find($me, $target);

		return "<a href=\"/_bors/tools/act/pub/bors_module_favorite/".($exists?'remove':'add')."/?target={$target->internal_uri_ascii()}\">".ec($exists ? 'Удалить из избранного' : 'Добавить в избранное')."</a>";
	}

	function public_action_add()
	{
		$target = bors_load_uri($this->args('target'));
		bors_user_favorite::add(bors()->user(), $target);
		return go($target->url());
	}

	function public_action_remove()
	{
		$target = bors_load_uri($this->args('target'));
		bors_user_favorite::remove(bors()->user(), $target);
		return go($target->url());
	}
}
