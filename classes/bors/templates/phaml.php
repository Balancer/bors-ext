<?php

// Заготовка под использование php-haml шаблонов
// 22.09.2011 — можно сказать, что работает (http://code.google.com/p/phamlp/)
// 20.06.2014 — перевод на использование Composer mthaml/mthaml

class bors_templates_phaml
{
	static function fetch($template, $data)
	{
		$haml = new MtHaml\Environment('php');
		$template = str_replace('xfile:', '', $template);

		$executor = new MtHaml\Support\Php\Executor($haml, array(
			'cache' => config('cache_dir'). '/mthaml',
		));

		$html = $executor->render($template, $data);

		return $html;
	}
}
