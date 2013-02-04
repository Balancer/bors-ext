<?php

class bors_tests_texts_unittest extends PHPUnit_Framework_TestCase
{
	public function test_bors_close_tags()
	{
		$text = "<p><i>Test</i></p>";
		$this->assertEquals($text, bors_close_tags($text));

		$text = "<p><i>Test</i>";
		$this->assertEquals($text.'</p>', bors_close_tags($text));

		$text = "<p><p><i>Test";
//		Вариант с DOM не такой, а строкой ниже. Так как в <p><p> второй <p>
//		воспринимается как закрытие предыдущего незакрытого параграфа
//		$this->assertEquals($text.'</i></p></p>', bors_close_tags($text));
		$this->assertEquals('<p></p><p><i>Test</i></p>', bors_close_tags($text));


		$text = "<p><i>Test</div></table>";
//		$this->assertEquals('<table><div>'.$text.'</i></p>', bors_close_tags($text));
//		И тут тоже DOM выкидывает лишнее.
		$this->assertEquals('<p><i>Test</i></p>', bors_close_tags($text));
	}

	public function test_bors_close_bbtags()
	{
		$text = "[p][i]Test[/i][/p]";
		$this->assertEquals(bors_close_bbtags($text), $text);

		$text = "[p][i]Test[/i]";
		$this->assertEquals(bors_close_bbtags($text), $text.'[/p]');

		$text = "[p][p][i]Test";
		$this->assertEquals(bors_close_bbtags($text), $text.'[/i][/p][/p]');

		$text = "[p][i]Test[/div][/table]";
		$this->assertEquals(bors_close_bbtags($text), '[table][div]'.$text.'[/i][/p]');
	}
}
