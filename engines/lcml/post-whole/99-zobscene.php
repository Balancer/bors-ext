<?php

function lcml_zobscene($text)
{
	if(class_include('blib_obscene'))
		$text = blib_obscene::mask($text, config('lcml.obscene_abusive', true));

	return $text;
}
