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

	function body_data()
	{
		$data = array();
		if($uid = $this->arg('uid'))
		{
			$data['uid'] = $uid;
			$data['pid'] = md5($uid);
		}
		else
		{
			$data['uid'] = preg_replace('!^(http://[^/]+):\d+!', '$1', bors()->main_object()->url());
			$data['pid'] = md5($data['uid']);
		}

		return array_merge(parent::body_data(), $data);
	}
}
