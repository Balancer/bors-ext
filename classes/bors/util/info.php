<?php

class bors_util_info
{
	static function run($argv)
	{
		echo 'COMPOSER_ROOT='.COMPOSER_ROOT.PHP_EOL;
		echo 'BORS_CORE='.BORS_CORE.PHP_EOL;
		if(defined('BORS_LOCAL'))
			echo 'BORS_LOCAL='.BORS_LOCAL.PHP_EOL;
	}
}
