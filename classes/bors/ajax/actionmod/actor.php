<?php

class bors_ajax_actionmod_actor extends bors_object
{
	function pre_show()
	{
		$path = explode('/', $this->id());
		$action = 'action_'.array_pop($path);
		$class_name = 'ajax_actionmod_'.join('_', $path);
		$args = bors()->request()->data();
//		var_dump($class_name, $action, $args);

		$actor = bors_load($class_name, NULL);

		if(!method_exists($actor, $action))
			return true;

		$result = $actor->call($action, &$args);
		if($result === true)
			return $result;

		$ref = $args['ref'];
//		echo "Found: $ref";
		return go($ref);

		if(is_array($data))
		{
			header('Content-type: application/json; charset: utf-8');
			echo json_encode($data);
		}
		else
		{
			header('Content-Type: text/html; charset: utf-8');
			echo $data;
		}

		return true;
	}
}
