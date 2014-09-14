<?php

include_once('inc/bors/lists.php');

function smarty_function_dropdown_id($params, &$smarty)
{
	extract($params);

	$params['name'] = '_'.$name;

	$form = bors_form::current_form();
	$form->append_attr('override_fields', $name);

	$html = "<table class=\"null\"><tr><td>ID:</td><td>";
	$html .= $form->element_html('input', $params);
	$html .= "</td><td>";

	template_jquery();
	template_js("\$(function() {
	\$('select[name={$name}]').change(function(){
		\$('input[name=_{$name}]').val(\$(this).val())
	});
});");

	unset($params['maxlength'], $params['size']);

	$params['name'] = $name;
	$html .= $form->element_html('dropdown', $params);
	$html .= "</td></tr></table>";

	echo $html;
}
