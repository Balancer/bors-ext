<?php

if($cr = getenv('COMPOSER_ROOT'))
{
	define('COMPOSER_ROOT', $cr);
	$GLOBALS['bors.composer.class_loader'] = require COMPOSER_ROOT.'/vendor/autoload.php';
	define('COMPOSER_INCLUDED', true);
}

if(defined('COMPOSER_ROOT') && ($init_class = getenv('INIT_CLASS')))
	$init_class::instance()->init();

if(!defined('COMPOSER_ROOT'))
{
	if(preg_match('!^(.+composer)/vendor/.+!', getcwd(), $m))
		define('COMPOSER_ROOT', $m[1]);
	elseif(file_exists(($dir = __DIR__.'/../../../..').'/vendor/autoload.php'))
		define('COMPOSER_ROOT', $dir);
	elseif(file_exists(($dir = '/var/www/bors/composer').'/vendor/autoload.php'))
		define('COMPOSER_ROOT', $dir);
	elseif(file_exists(($dir = '/var/www/composer').'/vendor/autoload.php'))
		define('COMPOSER_ROOT', $dir);

	$GLOBALS['bors.composer.class_loader'] = require COMPOSER_ROOT.'/vendor/autoload.php';
	define('COMPOSER_INCLUDED', true);
}

if(!defined('BORS_CORE') && getenv('BORS_CORE'))
	define('BORS_CORE', getenv('BORS_CORE'));

if(!defined('BORS_CORE') && file_exists($f = __DIR__.'/setup.php'))
	require_once($f);

//	Сперва ищем bors-core в дереве текущего каталога
//	На всякий случай запомним последнее нахождение подкаталога classes
$latest_classes = NULL;
$dir = getcwd();

$class_dirs = array();

if(!defined('BORS_SITE') && getenv('BORS_SITE'))
	define('BORS_SITE', getenv('BORS_SITE'));

if(!defined('BORS_HOST') && getenv('BORS_HOST'))
	define('BORS_HOST', getenv('BORS_HOST'));

do
{
	if(is_dir("$dir/classes"))
	{
		$class_dirs[] = $dir;
		$latest_classes = $dir;
		if(!defined('BORS_SITE'))
			define('BORS_SITE', $dir);
	}

	if(file_exists($test_dir = "$dir/b2-core"))
		$class_dirs[] = $test_dir;

	if(!defined('BORS_CORE'))
	{
		if(file_exists($core = "$dir/bors-core"))
		{
			define('BORS_CORE', $core);
			break;
		}

	}

	$dir = dirname($dir);

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
//	define('BORS_APPEND', $latest_classes);
	define('BORS_APPEND', join(' ', $class_dirs));

if(!defined('BORS_SITE'))
	define('BORS_SITE', $latest_classes);

if(!defined('BORS_HOST') && file_exists($bh = dirname(BORS_CORE).'/bors-host'))
	define('BORS_HOST', $bh);

include_once(BORS_CORE.'/init.php');
config_set('system.use_sessions', false);

if(file_exists($f = __DIR__.'/config.php'))
	include_once($f);

if(file_exists($f = COMPOSER_ROOT.'/config-host.php'))
	require_once($f);
