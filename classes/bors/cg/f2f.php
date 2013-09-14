<?php

class bors_cg_f2f extends bors_object
{
	static function id_prepare($id)
	{
		if(preg_match('/^([\w\-]+)\.(\w+)\.(\w+)$/', $id, $m))
		{
			$class_name = "bors_cg_f2f_{$m[3]}_{$m[2]}";
			return bors_load($class_name, $m[1]);
		}

		return $id;
	}

	function pre_show()
	{
		header("Content-Type: {$this->mime_type()}; charset=utf-8");
		return parent::pre_show();
	}
}
