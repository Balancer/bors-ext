<?php

require_once('engines/lcml.php');

class bors_tests_lcml_unittest extends PHPUnit_Framework_TestCase
{
	public function test_lcml()
	{
		$text = "   ***   ";
		$this->assertEquals(lcml($text), $text);

		$text = "***";
		$this->assertEquals(lcml($text), $text);

		$text = "*тест*";
		$this->assertEquals(lcml($text), '<b>тест</b>');

		$text = "   *тест*   ";
		$this->assertEquals(lcml($text), '   <b>тест</b>   ');
	}
}
