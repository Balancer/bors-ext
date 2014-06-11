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
//		$text = preg_replace_callback("/(?<!(ра|ло|ли|ти|су))([xх])([yу][йияеeёю])/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/(?<!(ра|л.|ти|су|си))([xх])([yу][йияеeёю])/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/(\b)([xх])([yу][юя])/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/([xх])([yу][л][яи])(\b|[^г])/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/([^рpт][^аaи][xх])([yу])([йяеe]|её)/ui", 'blib_obscene::stars', $text);
		$text = preg_replace("/([^РрPpТтT][^АаAaИи])([XxХх])\.*[YyУу]\.*[йЙяЯеЕeEe]\.*/u","\$1\$2***",$text);

		$text = preg_replace_callback("/([Пп])([Ии][Зз3])([Ддж])/ui", 'blib_obscene::stars', $text);
		$text = preg_replace("/([Пп])\.*[Ии]\.*[Зз3]\.*[Дд]\.*/u","\$1***",$text);

		$text = preg_replace_callback("/(?<!(ам|ру|са|р.))([б6])(ля)\b/ui", 'blib_obscene::stars2',$text);
		$text = preg_replace("/([б6])[л][я][д]/ui", "\$1***",$text);
		//$text = preg_replace("/([Бб])[Лл][Яя]([дД]|\s)/u","\$1**\$2",$text);
//		$text = preg_replace_callback("/(?<!(ор|[рp][уyаaеe]))(б)(ля)(\b|д|\s)/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/\b(бл)(я[тд])(ь)\b/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/\b(бл)(я[тд])(ст|ск)/ui", 'blib_obscene::stars', $text);

//$text = preg_replace("/манд(а[^р]|а[^т]|и|е|у|ой|ы)/u","м***",$text);
		$text = preg_replace_callback("/\b([еeё])([б][aаиуyёeе])/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/(ое)(бе)(нь)/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/(?<!(л|н|т|д|ч|р|щ|и))([еeё])([б][aаиуy])(ть|л|сь|\b)/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/(?<!(р))([еeё])([б][л])([яюоуе])/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/([еeё])([б][Tт])(?!(ам))/ui", 'blib_obscene::stars', $text);
		$text = preg_replace("/([^рРpPлЛдДНнчЧтТTвВжщи])([ЕеEeЁё])[Бб]([\sTТтAaАаиИУуYy])/ui","\$1\$2**\$3",$text);
		$text = preg_replace_callback("/(бо)([ёе]б)/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/\b(при|за|у|под|подь|подъ|на)([еёe])([б])/ui", 'blib_obscene::stars', $text);


		$text = preg_replace_callback("/\b(за)(лу)(п[а-яё]+)/ui", 'blib_obscene::stars', $text);

		if($abusive)
		{
			$text = preg_replace("/\b([г])([aаoо])[BВв][HНн]/ui", "\$1***", $text);
//			$text = preg_replace("/([СсCc])[УуYy][КкKk]([аАaAиИеЕуУyY]|ой)/u","\$1**\$2",$text);
			$text = preg_replace("/([MmМм])[УуYy][Дд][AaАаИи]([лЛкКkK][аАaA]?)/u","\$1***\$2",$text);
			$text = preg_replace_callback("/(?<!(ки|ла))([п])(ид[ао]р)(\b|[ауеы])/ui", 'blib_obscene::stars2',$text);
		//$text = preg_replace("/([Пп])[Ии][Дд][AaАаOoОо]([PpРр])/u","\$1***\$2",$text);
		//$text = preg_replace("/жоп(а|и|е|у|ой)/u","ж**",$text);
		}

		return $text;
	}

	static function __unit_test($test)
	{
		$allowed = array('ансамбля Джебат дебаты колебания колебать колебаться постебаться дебилов учёба');
		$allowed[] = 'Усугубляясь истребители застрахуйте рубля Хулиганы потребляет потреблять тихую психуют психующим';
		$allowed[] = 'оскорблять уподобляться Усугубляясь Олеговна плохую лихую употребляющих сухую глухую';
		$allowed[] = 'хребтами Глеб Глеба небу сабля гребля корабля лапидарий скипидар туебень залужью';
		$allowed[] = 'абляция'; // В начале строки!
		$allowed[] = 'небу ещёб ещеб нёбу хлебом Пиебалгс';

		foreach($allowed as $s)
			$test->assertEquals($s, self::mask($s, true));

		$obscene = array('��� ����� ������� ����� ��� �������� �������� ����� ������');
		$obscene[] = '����� ���� ��������� ���� ������ �������� �������';
		$obscene[] = '��� ����� ���� ��� ��������� ������� �£���� ��������� ����ϣ� ����ϣ�� ���� �����';
		$obscene[] = '�����';
		$obscene[] = '���������� ������� �������� ����� ����� �����';
		$obscene[] = '������ ������� ������';

		foreach($obscene as $words)
		{
			foreach(explode(' ', iconv('koi8-r', 'utf-8', $words)) as $w)
			{
				$masked = self::mask($w, true);
				$test->assertNotEquals($w, $masked);
				$test->assertEquals(bors_strlen($w), bors_strlen($masked), "Tested words: '$w' => '$masked'");
			}
		}

		$obscene = explode(' ', 'говна пидоры пидарас');
		foreach($obscene as $w)
		{
			$masked = self::mask($w, true);
			$test->assertNotEquals($w, $masked);
			$test->assertEquals(bors_strlen($w), bors_strlen($masked));

			$masked = self::mask($w, false);
			$test->assertEquals($w, $masked);
		}
	}

	static function __dev()
	{
		$text = 'говно';
		echo self::mask($text, true), PHP_EOL;
	}
}
