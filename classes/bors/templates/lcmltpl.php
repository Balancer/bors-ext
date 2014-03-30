<?php

class bors_templates_lcmltpl extends bors_templates_smarty3
{
	static function fetch($template, $data)
	{
		$hts = parent::fetch($template, $data);
		return lcml($hts);
	}
}
