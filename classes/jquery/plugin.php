<?php

class jquery_plugin
{
	static function load($plugin_name, $preset_name=NULL, $package_name=NULL)
	{
		jquery::load();

		if(!$preset_name)
			$preset_name = 'jquery.'.$plugin_name;

		if(!$package_name)
			$package_name = 'balancer/bors-3rd-jquery-'.str_replace('_', '-', $plugin_name);

		$loader = \AssetsManager\Loader::getInstance();
		$package = $loader->getPackage($package_name);
		$preset = $loader->getPreset("jquery.$plugin_name");

		foreach($preset->getOrganizedStatements() as $type => $statements)
		{
			foreach ($statements as $statement)
			{
				$path = str_replace('../www/vendor', '/_bors-assets', $statement->__toString());
				switch($type)
				{
					case 'css':
						bors_use($path);
						break;
					case 'jsfiles_footer':
						jquery::plugin($path);
						break;
					case 'jquery_plugin':
						jquery::plugin('/js/'.$path.'.min.js');
						break;
					default:
						bors_throw('Unknown type '.$type);
				}
			}
		}
	}
}
