<?php

class bors_module_multicomments extends bors_module
{
	function is_smart() { return true; }

	function pre_show()
	{
		if($id = $this->arg('fb_app_id'))
			template_meta_prop('fb:app_id', $id);

		if($id = $this->arg('vk_api_id'))
			template_js_include("http://userapi.com/js/api/openapi.js?34");

		return parent::pre_show();
	}
}
