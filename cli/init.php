<?php

if(file_exists('setup_php'))
	include_once('setup.php');

if(!defined('BORS_CORE'))
{
	define('BORS_HOST', dirname(dirname(__FILE__)));
	define('BORS_CORE', dirname(BORS_HOST).'/bors-core');
}

include_once(BORS_CORE.'/init.php');
config_set('system.use_sessions', false);
