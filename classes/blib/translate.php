<?php

class blib_translate
{
	static function translate($text, $to, $from='RU')
	{
		bors_debug::syslog('translate', 'translate '.$to.': '.$text);

		$result = array();
		foreach(explode("\n", $text) as $s)
		{
			if(bors_strlen($s) <= 512 && !preg_match("/[\[\]<>&']/", trim($s)))
				$result[] = shell_exec("/usr/local/bin/trs {{$from}={$to}} '".$s."'");
			else
			{
//				if(config('is_developer')) { echo '<xmp>'; 	var_dump($s); echo '</xmp>'; }
				$result[] = $s;
			}
		}

		return join("\n", $result);
	}

	function __dev()
	{
		echo self::translate('Это просто тест', 'UK');
	}
}