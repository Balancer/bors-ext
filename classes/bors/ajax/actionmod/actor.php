<?php

class bors_ajax_actionmod_actor extends bors_object
{
	function pre_show()
	{
		$path = explode('/', $this->id());
		$action = 'action_'.array_pop($path);
		$class_name = join('_', $path);
		$args = bors()->request()->data();

		$actor = bors_load('ajax_actionmod_'.$class_name, NULL);
		if(!$actor)
		{
			$actor = bors_load($class_name, NULL);
			if($actor && !$actor->get('is_actionmod'))
				$actor = NULL;
		}

		if(!$actor || !method_exists($actor, $action))
		{
			echo "Incorrect actor or method";
			return true;
		}

		$result = $actor->call($action, $args);
		if($result === true)
			return $result;

		if($ref = @$args['ref'])
		{
	//		echo "Found: $ref";
			return go($ref);
		}

		if(is_array($result))
		{
			header('Content-type: application/json; charset: utf-8');
			echo json_encode($result);
		}
		else
		{
			header('Content-Type: text/html; charset: utf-8');
			echo $result;
		}

		return true;
	}
}
