<?php

class typo_rustypo
{
	static function parse($text)
	{
		require_once('inc/rustypo.php');
		$typo = new plgContentRustypo;
		$article = array();
		$params = array();
		return $typo::onContentPrepare(NULL, $article, $params);
	}

	static function __unit_test($suite)
	{
//		$suite->assertEquals('x', typo_rustypo::parse('Это - тест'));
	}
}
