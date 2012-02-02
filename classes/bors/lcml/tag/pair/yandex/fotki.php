<?php

class bors_lcml_tag_pair_yandex_fotki extends bors_lcml_tag_pair
{
	function html($id, &$params = array())
	{
		$params['skip_around_cr'] = 'full';
		return save_format(bors_external_yandex_fotki::factory($id)->html());
	}
}
