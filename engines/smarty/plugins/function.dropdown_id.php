<?php

include_once('inc/bors/lists.php');

function smarty_function_dropdown_id($params, &$smarty)
{
	extract($params);

	$params['name'] = '_'.$name;

	$form = $smarty->getTemplateVars('form');
	bors_form::append_attr('override_fields', $name);

	$html = "<table class=\"null\"><tr><td>ID:</td><td>";
	$html .= bors_forms_input::html($params);
	$html .= "</td><td>";

	template_jquery();
	template_js("\$(function() {
	\$('select[name={$name}]').change(function(){
		\$('input[name=_{$name}]').val(\$(this).val())
	});
});");

	unset($params['maxlength'], $params['size']);

	$params['name'] = $name;
	$html .= bors_forms_dropdown::html($params);
	$html .= "</td></tr></table>";

	echo $html;
}
