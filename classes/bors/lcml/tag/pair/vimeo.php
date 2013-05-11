<?php

/**
	Тег, отображающий видео с хостинга vimeo.com
	Пример использования: [vimeo]...[/vimeo]
*/

class bors_lcml_tag_pair_vimeo extends bors_lcml_tag_pair
{
	function html($vimeo_id, &$params = array())
	{
		$params['skip_around_cr'] = true;
		return save_format(bors_external_vimeo::factory($vimeo_id)->html($params));
	}
}
