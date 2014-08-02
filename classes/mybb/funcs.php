<?php

class mybb_funcs
{
	static function my_ip2long($ip)
	{
		$ip_long = ip2long($ip);

		if(!$ip_long)
		{
			$ip_long = sprintf("%u", ip2long($ip));

			if(!$ip_long)
			{
				return 0;
			}
		}

		if($ip_long >= 2147483648) // Won't occur on 32-bit PHP
		{
			$ip_long -= 4294967296;
		}

		return $ip_long;
	}
}
