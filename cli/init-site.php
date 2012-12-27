<?php

if(!defined('BORS_CORE'))
	@include_once(dirname(__FILE__).'/setup.php');

if(!defined('BORS_CORE'))
{
	$dir = getcwd();
	do
	{
		$dir = dirname($dir);
		if(file_exists($core = "$dir/bors-core"))
		{
			define('BORS_CORE', $core);
			break;
		}
	} while ($dir > '/');
}

if(!defined('BORS_CORE'))
	exit("Can't find bors-core\n");

include_once(BORS_CORE.'/init.php');
config_set('system.use_sessions', false);

if(file_exists($f = dirname(__FILE__).'/config.php'))
	include_once($f);
