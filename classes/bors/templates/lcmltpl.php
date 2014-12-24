<?php

class bors_templates_lcmltpl extends bors_templates_smarty3
{
	static function fetch($template, $data)
	{
		$hts = parent::fetch($template, $data);
		return bors_lcml::lcml($hts, array('container' => $data['self']));
	}
}
