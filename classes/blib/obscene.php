<?php

class blib_obscene
{
	static $map = array(
		'x' => 'х',
		'y' => 'у',
		'0' => 'o',
	);

	static function stars($m) { return $m[1] . str_repeat('*', bors_strlen($m[2])) . @$m[3]; }
	static function stars2($m) { return $m[2] . str_repeat('*', bors_strlen($m[3])) . @$m[4]; }

	static function mask($text, $abusive = false)
	{
		$text = preg_replace_callback("/(?<!(ра))([xх])([yу][йияюеeё])/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/([xх])([yу][л][яи])(\b|[^г])/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/([^рpт][^аaи][xх])([yу])([йяюеe]|её)/ui", 'blib_obscene::stars', $text);
		$text = preg_replace("/([^РрPpТтT][^АаAaИи])([XxХх])\.*[YyУу]\.*[йЙяЯюЮеЕeEe]\.*/u","\$1\$2***",$text);
		$text = preg_replace("/([Пп])[Ии][Зз3][Дд]/u","\$1***",$text);
		$text = preg_replace("/([Пп])\.*[Ии]\.*[Зз3]\.*[Дд]\.*/u","\$1***",$text);
		$text = preg_replace("/(?<![рpо][уyaар])([б6])[л][я]$/ui","\$2**",$text);
		$text = preg_replace("/([б6])[л][я][д]/ui","\$1***",$text);
		//$text = preg_replace("/([Бб])[Лл][Яя]([дД]|\s)/u","\$1**\$2",$text);
		$text = preg_replace_callback("/(?<!(ор|[рp][уyаaеe]))(б)(ля)(\b|д|\s)/ui", 'blib_obscene::stars', $text);
//$text = preg_replace("/манд(а[^р]|а[^т]|и|е|у|ой|ы)/u","м***",$text);
		$text = preg_replace("/^([ЕеEeЁё])[Бб][TТтAaАаиУуYy]/u","\$1***",$text);
		$text = preg_replace("/([^рРpPлЛдДНнчЧтТTвВ])([ЕеEeЁё])[Бб]([\sTТтAaАаиИУуYy])/u","\$1\$2**\$3",$text);
		$text = preg_replace("/(?<![СсCc][КкKk][Ии])([Пп])[Ии][Дд][AaАаOoОо]([PpРр])/u","\$1***\$2",$text);

		$text = preg_replace("/(\s|при|за|у|под|на)[еEёЁeE][бБ]/u","\$1e*",$text);

		if($abusive)
		{
			$text = preg_replace("/([г])([aаoо])[BВв][HНн]/ui", "\$1***", $text);
			$text = preg_replace("/([СсCc])[УуYy][КкKk]([аАaAиИеЕуУyY]|ой)/u","\$1**\$2",$text);
			$text = preg_replace("/([MmМм])[УуYy][Дд][AaАаИи]([лЛкКkK][аАaA]?)/u","\$1***\$2",$text);
		//$text = preg_replace("/([Пп])[Ии][Дд][AaАаOoОо]([PpРр])/u","\$1***\$2",$text);
		//$text = preg_replace("/жоп(а|и|е|у|ой)/u","ж**",$text);
		}

		return $text;
	}

	function __unit_test($test)
	{
		$allowed = 'Усугубляясь истребители застрахуйте рубля Хулиганы потребляет потреблять'
			.'оскорблять уподобляться Усугубляясь';
		$test->assertEquals($allowed, self::mask($allowed, true));
		$obscene = explode(' ', iconv('koi8-r', 'utf-8', '�����'));
		foreach($obscene as $w)
		{
			$masked = self::mask($w, true);
			$test->assertNotEquals($w, $masked);
			$test->assertEquals(bors_strlen($w), bors_strlen($masked));
		}
	}

	function __dev()
	{
		$text = base64_decode('0JzQvdC+0LPQviDRgdGC0LDQu9C+INCyINC90LDRiNC4INC00L3QuCDQvdC10L7Qv9C+0LfQvdCw0L3QvdC+0LkgWNCj0JnQndCYLgo=')
			.base64_decode('0JTQsCDRhdGD0LvQuCDRgtCw0LwsINCh0L/QtdGA0LzQsNC90LTQsNCx0LvRj9C00YHQutCw0Y8g0L/QuNC30LTQvtC/0YDQvtGR0LHQuNC90LAg0LrQsNC60LDRjy3RgtC+Lgo=')
			.base64_decode('0K8g0YXRg9C10Y4sINC00L7RgNC+0LPQsNGPINGA0LXQtNCw0LrRhtC40Y8uCg==')
			.base64_decode('0JTQsNC50YLQtSDRgdCy0L7QsdC+0LTRgywg0YHRg9C60LghINCc0YPQtNCw0LrQuCDQnNGD0LDQtCDQlNC40LHQsC4g0JHQtdGA0LzRg9C00YHQutC40Lkg0YLRgNC+0LXQsdCw0LvRjNC90LjQui4K')
			.base64_decode('0KHQvtCy0YHQtdC8INC+0YXRg9C10LvQuCDQsdC70Y/QtNC4');
		echo self::mask($text, true), PHP_EOL;
//		require_once('engines/lcml/main.php');
//		echo lcml($text), PHP_EOL;
	}
}
