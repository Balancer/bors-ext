<?php

class typo_rustypo
{
	static function parse($text)
	{
		require_once('inc/rustypo.php');
		$typo = new plgContentRustypo;
		return $typo::onContentPrepare(NULL, array(), true);
	}

	static function __unit_test($suite)
	{
		$suite->assertEquals('x', typo_rustypo::parse('Это - тест'));
	}
}
