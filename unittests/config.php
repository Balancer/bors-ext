<?php

config_set('phpunit_include', 'PHPUnit');
config_set('output_charset', 'utf8');

$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__).'/htdocs';

register_vhost('localhost', $_SERVER['DOCUMENT_ROOT']);

//config_set('unit-test.mysql.db', 'BORS_UNIT_TEST');
config_set('can-drop-tables', true);
config_set('main_bors_db', config('unit-test.mysql.db'));
config_set('bors_core_db', config('unit-test.mysql.db')); // Этим оперируют cross-методы

config_set('debug.show_variables', true);

config_set('mysql_tables_autocreate', true);
config_set('smarty3_enable', true);

config_set('cache_dir', '/tmp/bors-cache/unittests');

require_once(dirname(__FILE__).'/config-host.php');

function bors_unit_test_up()
{
	$dbh = new driver_mysql(config('unit-test.mysql.db'));
}

function is_connected()
{
	if(($connected = @fsockopen("google.com", 80)))
	{
		$is_conn = true;
		fclose($connected);
	}
	else
		$is_conn = false;

	return $is_conn;
}

//TODO: сделать автонастройку проверки
config_set('unittests.skip.internet', ! is_connected());
