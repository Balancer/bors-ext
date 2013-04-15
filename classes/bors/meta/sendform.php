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
				$title = $m[1].'&nbsp;<span style="color:red">'.str_repeat('*', $m[2]).'</span>';
			set_def($params, 'title', $title);

			$html[] = $form->element_html_smart($params);
		}

		$html[] = $form->element_html('submit', array('title' => 'Отправить'));

		$html[] = $form->html_close();

		foreach($notes as $id => $note)
			$html[] = '<div style="padding-left: 20px;"><span style="color:red">'.str_repeat('*', $id).'</span> &mdash; '.$note."</div>";

		return join("\n", $html);
	}
}
