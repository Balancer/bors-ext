<?php

class bors_tests_templates_phaml extends bors_page
{
	function body_data()
	{
		return array_merge(parent::body_data(), array(
			'test' => '123',
		));
	}
}
