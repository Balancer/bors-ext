<?php

class bors_ext
{
	static function load_css($css = 'ext.css')
	{
		bors_use("/_bors-ext/css/{$css}");
	}
}
