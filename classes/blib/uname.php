<?php

class blib_uname
{
	static function minify($name)
	{
		$name = strtr($name, array(
			'а' => 'a',
			'А' => 'A',
			'б' => '6',
			'В' => '8',
			'г' => 'r',
			'е' => 'e',
			'Е' => 'E',
			'З' => '3',
			'К' => 'K',
			'М' => 'M',
			'Н' => 'H',
			'О' => '0',
			'о' => 'o',
			'Р' => 'P',
			'р' => 'p',
			'С' => 'C',
			'с' => 'c',
			'Т' => 'T',
			'у' => 'y',
			'Х' => 'X',
			'х' => 'x',
			'Ч' => '4',
			'ь' => 'b',
			'O' => '0',
			'l' => '1',
			'I' => '1',
			'S' => '5',
			'B' => '8',
		));

		$name = preg_replace('/[^\wа-яА-ЯёЁ]+/u', ' ', $name);
		$name = trim(preg_replace('/\s+/s', ' ', $name));
		return bors_lower($name);
	}

	static function __unit_test($suite)
	{
		$name = 'Аgreсcor';
		$suite->assertEquals('agreccor', blib_uname::minify($name));

		$suite->assertEquals('car1os', blib_uname::minify('carlos ★✈☭☂✖'));
	}
}
