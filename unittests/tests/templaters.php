<?php

class templaters_unittest extends PHPUnit_Framework_TestCase
{
    public function test_php()
    {
		$x = bors_load('bors_tests_templates_php', NULL);
		$this->assertNotNull($x);
		$this->assertEquals('123', $x->body());
	}

    public function test_phaml()
    {
		$x = bors_load('bors_tests_templates_phaml', NULL);
		$this->assertNotNull($x);
		$this->assertEquals('<p>test</p><p>more test</p><p>123</p>', preg_replace('/>\s+/', '>', trim($x->body())));
	}
}
