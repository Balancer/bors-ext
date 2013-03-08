<?php

class bors_callback_opauth extends bors_object
{
	function is_callback() { return true; }

	function pre_show()
	{
		require_once('composer/vendor/autoload.php');

		return "Ok!";
	}
}
