<?php

class bors_lcml_tag_pair_youtube extends bors_lcml_tag_pair
{
	function html($id, &$params=array())
	{
		$youtube = new bors_external_youtube($id);
		return $youtube->html($params);
	}

	function text($id, &$params=array())
	{
		$youtube = new bors_external_youtube($id);
		return $youtube->text($params);
	}

	static function __unit_test($suite)
	{
		if(config('unittests.skip.internet'))
			return;

		$url = 'http://www.youtube.com/watch?v=IO2h-yzTOhs&list=UUNtclu0DvBOkjbVYhZZUcdA&index=4&feature=plcp';
		$html = bors_external_youtube::url2html($url);
		$suite->assertRegexp('/<iframe.*v=IO2h-yzTOhs/', $html);
	}
}
