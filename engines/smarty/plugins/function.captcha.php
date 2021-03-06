<?php

function smarty_function_captcha($params, &$smarty)
{
	extract($params);
    if(empty($type))
    {
        $smarty->trigger_error("Undefined CAPTCHA type");
        return;
    }

	$captcha_class = "bors_form_captcha_".$type;

	echo call_user_func(array($captcha_class, 'html'), $params);
}
