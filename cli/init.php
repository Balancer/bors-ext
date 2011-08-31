<?php

if(file_exists($f = dirname(__FILE__).'/setup.php'))
	include_once($f);

if(!defined('BORS_CORE'))
{
	define('BORS_HOST', dirname(dirname(__FILE__)));
	define('BORS_CORE', dirname(BORS_HOST).'/bors-core');
}

include_once(BORS_CORE.'/init.php');
config_set('system.use_sessions', false);
