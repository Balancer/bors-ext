<?php

class lcml_tag_pair_flickr extends bors_lcml_tag_pair
{
	function html($id, &$params = array())
	{
		$params['skip_around_cr'] = true;
		return save_format(bors_external_flickr_photo::factory($id, $params)->html());
	}
}
