<?php

class blib_benchmark
{
	static function run($functions, $args, $loops = 1000)
	{
		if(!is_array($functions))
			$functions = array($functions);

		foreach($functions as $f)
		{
			if(is_array($f))
				$fname = "{$f[0]}::{$f[1]}";
			else
				$fname = $f;
			echo "$fname ... ";
			$start = microtime(true);
			for($i=0; $i<$loops; $i++)
				call_user_func_array($f, $args);
			$time = microtime(true) - $start;
			echo sprintf('%.3f', $time), PHP_EOL;
		}
	}
}
