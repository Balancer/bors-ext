<?php

$d = dirname(__FILE__);
if(file_exists($d.'/config-3rd.ini'))
	bors_config_ini($d.'/config-3rd.ini');

if(file_exists($d.'/config-3rd.php'))
	require_once($d.'/config-3rd.php');
