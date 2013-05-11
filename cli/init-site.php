<?php

if(!defined('BORS_CORE'))
	@include_once(dirname(__FILE__).'/setup.php');

//	Сперва ищем bors-core в дереве текущего каталога
//	На всякий случай запомним последнее нахождение подкаталога classes
$latest_classes = NULL;
$dir = getcwd();

do
{
	$dir = dirname($dir);

	if(is_dir("$dir/classes"))
		$latest_classes = $dir;

	if(!defined('BORS_CORE'))
	{
		if(file_exists($core = "$dir/bors-core"))
		{
			define('BORS_CORE', $core);
			break;
		}
	}

} while ($dir > '/');

//	Если не нашли, ищем в дереве каталога самого исходного файла
// 	А текущее дерево (по найденному ранее classes) добавим в BORS_APPEND
if(!defined('BORS_CORE'))
{
	$dir = __DIR__;
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

if($latest_classes && !defined('BORS_APPEND'))
	define('BORS_APPEND', $latest_classes);

if(!defined('BORS_SITE'))
	define('BORS_SITE', BORS_APPEND);

if(!defined('BORS_HOST') && file_exists($bh = dirname(BORS_CORE).'/bors-host'))
	define('BORS_HOST', $bh);

include_once(BORS_CORE.'/init.php');
config_set('system.use_sessions', false);

if(file_exists($f = dirname(__FILE__).'/config.php'))
	include_once($f);
