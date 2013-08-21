<?php

class bors_gvar
{
	static function hash()
	{
		if($hash = @$_COOKIE['bors_gvar_hash'])
			return $hash;

		$hash = md5(rand());
		setcookie('bors_gvar_hash', $hash, time()+86400*365, '/');
		return $_COOKIE['bors_gvar_hash'] = $hash;
	}

	static function set($name, $value)
	{
		$hash = self::hash();
		bors_new('bors_user_gvar', array(
			'id' => $hash,
			'var_name' => $name,
			'var_value' => json_encode($value),
		));
	}

	static function get($name, $default = NULL)
	{
		$hash = self::hash();
		$var = bors_find_first('bors_user_gvar', array(
			'id' => $hash,
			'var_name' => $name,
		));

		if(!$var)
			return $default;

		return json_decode($var->var_value(), true);
	}
}
