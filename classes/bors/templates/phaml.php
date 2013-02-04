<?php

// Заготовка под использование php-haml шаблонов
// 22.09.2011 — можно сказать, что работает

// http://code.google.com/p/phamlp/

class bors_templates_phaml
{
	static function fetch($template, $data)
	{
		require_once config('phamlp_path').'/haml/HamlParser.php';

		$haml = new HamlParser(array('style'=>'nested'));
		$template = str_replace('xfile:', '', $template);
//		echo "\n-------------\n$template:\n".file_get_contents($template)."\n---------------\n\n";

		$php = $haml->parse($template);

		// Результат парсинга — php-контент. Сохраним его и заинклудим

		$tmp = tempnam(config('cache_dir'), 'phamlp-');
		file_put_contents($tmp, $php);

		ob_start();
		$err_rep_save = error_reporting();
		error_reporting($err_rep_save & ~E_NOTICE);
		extract($data);
		require($tmp);
		error_reporting($err_rep_save);
		$html = ob_get_contents();
		ob_end_clean();

		unlink($tmp);

		return $html;
	}
}
