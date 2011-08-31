<?php

if(file_exists('setup_php'))
	include_once('setup.php');

include_once(BORS_CORE.'/init.php');
config_set('system.use_sessions', false);
