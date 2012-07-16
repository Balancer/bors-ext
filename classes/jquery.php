<?php

/**
	Унифицированная работа с jQuery и его плагинами
*/

class jquery
{
	static function load()
	{
		// Со временем поменять местами
		template_jquery();
	}

	static function plugin($name)
	{
		template_jquery_plugin($name);
	}

	static function on_ready($js_code)
	{
		template_jquery_document_ready($js_code)
	}
}
