<?php

// Заготовка под использование php-haml шаблонов
// 22.09.2011 — можно сказать, что работает

// http://code.google.com/p/phamlp/

class bors_templates_phaml
{
	static function fetch($template, $data)
	{
//		require_once config('phamlp_path').'/haml/HamlParser.php';

//		$haml = new HamlParser(array('style'=>'nested'));
		$haml = new MtHaml\Environment('php');
		$template = str_replace('xfile:', '', $template);
//		echo "\n-------------\n$template:\n".file_get_contents($template)."\n---------------\n\n";

		$executor = new MtHaml\Support\Php\Executor($haml, array(
			'cache' => config('cache_dir'). '/mthaml',
		));

		ob_start();

		$executor->display($template, array(
			'var' => 'value',
		));

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}
