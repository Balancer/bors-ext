<?php

if(!defined('BORS_CORE'))
	require_once(dirname(__FILE__).'/setup.php');

include_once(BORS_CORE.'/init.php');
config_set('system.use_sessions', false);

if(file_exists($f = dirname(__FILE__).'/config.php'))
	include_once($f);
