<?php

class bors_lcml_tag_pair_flickr extends bors_lcml_tag_pair
{
	function html($id)
	{
		return bors_external_flickr_photo::factory($id)->html();
	}
}
