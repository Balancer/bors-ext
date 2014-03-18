<?php

class jquery_tinymce
{
	function load()
	{
		jquery::plugin(config('tinymce.path').'/jquery.tinymce.js');
	}

	function appear($elem, $mode)
	{
		self::load();
		jquery::on_ready("$({$elem}).tinymce({ script_url : \""
			.config('tinymce.path')."/tiny_mce.js\", "
			.file_get_contents(BORS_3RD_PARTY.'/inc/tinymce/'.$mode.'.inc').' });');
	}
}
