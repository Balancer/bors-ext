<?php

class typo_rustypo
{
	static function parse($text)
	{
		
	}

	static function __unit_test($suite)
	{
		$suite->assertEquals('x', type_rustypo::parse('Это - тест'));
	}
}
