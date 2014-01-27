<?php

class bors_templates_bbhtpl extends bors_templates_smarty3
{
	static function fetch($template, $data)
	{
		$hts = parent::fetch($template, $data);
		return lcml_bbh($hts);
	}
}
