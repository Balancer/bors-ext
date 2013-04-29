<?php

// http://mbfi.wrk.ru/callback/

class bors_meta_sendform extends bors_page
{
	function _form_fields_def() { return array(); }

	function _form_html_def()
	{
		$html = array();

		$fields	= $this->form_fields();
		$notes	= popval($fields, '*notes');
		$act	= popval($fields, '*act');

		$form = bors_form::factory();

		$html[] = $form->html_open(array(
			'act' => $act,
			'th' => '-',
		));

		foreach($fields as $field_name => $params)
		{
			if(!is_array($params))
			{
				$params = array(
					'title'	=> $params,
					'type'	=> 'string',
					'value' => NULL,
				);
			}

			set_def($params, 'name', $field_name);
			set_def($params, 'type', 'string');

			$title = popval($params, 'title');
			if(preg_match('/^(.+)\[(\d+)\]$/', $title, $m))
				// Голубой цвет используется на mbfi/callback
				$title = $m[1].'&nbsp;<span style="color:blue">'.str_repeat('*', $m[2]).'</span>';
			set_def($params, 'title', $title);

			$html[] = $form->element_html_smart($params);
		}

		$html[] = $form->element_html('submit', array('title' => 'Отправить'));

		$html[] = $form->html_close();

		if($notes)
			foreach($notes as $id => $note)
				// Голубой цвет используется на mbfi/callback
				$html[] = '<div style="padding-left: 20px;"><span style="color:blue">'.str_repeat('*', $id).'</span> &mdash; '.$note."</div>";

		return join("\n", $html);
	}

	// mbfi/callback
	function field_string($req_field_name, $data)
	{
		foreach($this->form_fields() as $field_name => $params)
		{
			if(!is_array($params))
			{
				$params = array(
					'title'	=> $params,
					'type'	=> 'string',
					'value' => NULL,
				);
			}

			set_def($params, 'name', $field_name);
			set_def($params, 'type', 'string');

			if($field_name == $req_field_name)
			{
				$list = defval($params, 'list');
//				var_dump($data[$req_field_name], $list, $list[$data[$req_field_name]]);
				if(is_array($list))
					return $list[$data[$req_field_name]];

				return $data[$req_field_name];
			}
		}
	}
}
