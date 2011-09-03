<?php

$UNITTESTS_DIR = dirname(__FILE__);

if(file_exists("$UNITTESTS_DIR/setup-host.php"))
	include_once("$UNITTESTS_DIR/setup-host.php");

if(!defined('BORS_CORE'))
	define('BORS_CORE', dirname(dirname($UNITTESTS_DIR)).'/bors-core');

if(!defined('BORS_SITE'))
	define('BORS_SITE', $UNITTESTS_DIR);
