<?php

class bors_tests_templates_php extends bors_page
{
	function body_data()
	{
		return array_merge(parent::body_data(), array(
			'test' => '123',
		));
	}
}
