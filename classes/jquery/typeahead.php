<?php

class jquery_typeahead
{
	function appear($el, $attrs)
	{
		jquery::plugin('/_bors-3rd/jquery/plugins/typeahead.min.js');

		$attrs = blib_json::encode_jsfunc($attrs);

		jquery::on_ready("$({$el}).typeahead($attrs)\n");
	}
}
