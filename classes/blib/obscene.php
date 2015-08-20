<?php

class blib_obscene
{
	static $map = array(
		'x' => 'х',
		'y' => 'у',
		'0' => 'o',
	);

	static function stars($m) { return $m[1] . str_repeat('*', bors_strlen($m[2])) . (empty($m[3])?'':$m[3]); }
	static function stars2($m) { return $m[2] . str_repeat('*', bors_strlen($m[3])) . (empty($m[4])?'':$m[4]); }
	static function stars3($m) { return $m[2] . str_repeat('*', bors_strlen($m[3])) . @$m[4] . @$m[5]; }

	static function mask($text, $abusive = false)
	{
//		$text = preg_replace_callback("/(?<!(ра|ло|ли|ти|су))([xх])([yу][йияеeёю])/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/(?<!(ра|л.|ри|ти|су|си))([xх])([yу][йияеeёю])/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/(\b)([xх])([yу][юя])/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/([xх])([yу][л][яие])(\b|[^гтамн])/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/([^рpт][^аaи][xх])([yу])([йяеe]|её)/ui", 'blib_obscene::stars', $text);
		$text = preg_replace("/([^РрPpТтT][^АаAaИи])([XxХх])\.*[YyУу]\.*[йЙяЯеЕeEe]\.*/u","\$1\$2***",$text);
		$text = preg_replace_callback("/(при)([х][у][е])([а-яё])/ui", 'blib_obscene::stars', $text);

		$text = preg_replace_callback("/([Пп])([Ии][Зз3])([Ддж])/ui", 'blib_obscene::stars', $text);
		$text = preg_replace("/([Пп])\.*[Ии]\.*[Зз3]\.*[Дд]\.*/u","\$1***",$text);

		$text = preg_replace_callback("/(?<!(ам|са|жа|р.|ду))([б6])(ля)\b/ui", 'blib_obscene::stars2',$text);
		$text = preg_replace("/([б6])[л][я][д]/ui", "\$1***",$text);
		//$text = preg_replace("/([Бб])[Лл][Яя]([дД]|\s)/u","\$1**\$2",$text);
//		$text = preg_replace_callback("/(?<!(ор|[рp][уyаaеe]))(б)(ля)(\b|д|\s)/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/\b(бл)(я[тд])(ь)\b/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/\b(бл)(я[тд])(ст|ск)/ui", 'blib_obscene::stars', $text);

//$text = preg_replace("/манд(а[^р]|а[^т]|и|е|у|ой|ы)/u","м***",$text);
		$text = preg_replace_callback("/\b([еeёи])([б][aаиуyёeело0o])\B/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/([оo0][еe])([б6][еe])(нь)/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/(?<!(л|н|т|д|ч|р|щ|и|б|в))([еeё])([б][aаиуy])(ть|л|сь|\b)/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/(?<!(р|д|л|з|н|т|с|щ))([еeё])([б][л])([яюоo0уе])/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/(?<!(р))([еeё])([б][Tт])(?!(ам|[оo0].|у\b))/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/(?<!(л|д|ч|ш|р))([еeё])(бн)(у)/ui", 'blib_obscene::stars2', $text);
		$text = preg_replace_callback("/(б[оo0])([ёе]б)/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/\b(при|пр[оo0]|за|у|п[оo0]д|п[оo0]дь|п[оo0]дъ|на)([еёe])([б])/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/(вы|пере|разъ)([еёeи])([б])/ui", 'blib_obscene::stars', $text);
		$text = preg_replace_callback("/(зл[оo0])([еёe][б])(.+)/ui", 'blib_obscene::stars', $text);

		$text = preg_replace_callback("/\b(за)(лу)(п[а-яё]+)/ui", 'blib_obscene::stars', $text);

		if($abusive)
		{
			$text = preg_replace_callback("/\b([г])([aаoо0][BВв])([HНн])/ui", 'blib_obscene::stars',$text);
//			$text = preg_replace("/([СсCc])[УуYy][КкKk]([аАaAиИеЕуУyY]|ой)/u","\$1**\$2",$text);
			$text = preg_replace_callback("/(?<!(ки|ла))([п])(ид[аоo0])(р)(\b|[ауеы])/ui", 'blib_obscene::stars3',$text);
			$text = preg_replace_callback("/(му)(да|ди)(к|ч|л)/ui", 'blib_obscene::stars', $text);
			//$text = preg_replace("/жоп(а|и|е|у|ой)/u","ж**",$text);
		}

		return $text;
	}

	static function __unit_test($test)
	{
		// Список нормальных слов с выглядещами обсценно подстроками.
		$allowed = array('ансамбля Джебат дебаты колебания колебать колебаться постебаться дебилов учёба');
		$allowed[] = 'Усугубляясь истребители застрахуйте рубля Хулиганы потребляет потреблять тихую психуют психующим';
		$allowed[] = 'оскорблять уподобляться Усугубляясь Олеговна плохую лихую употребляющих сухую глухую';
		$allowed[] = 'хребтами Глеб Глеба небу сабля гребля корабля лапидарий скипидар туебень залужью';
		$allowed[] = 'абляция'; // В начале строки!
		$allowed[] = 'аббляционного веба потребляемого стеблями';
		$allowed[] = 'небу ещёб ещеб нёбу хлебом Пиебалгс деблокировать хлебнуло хулит';
		$allowed[] = 'хребтом хребтами хребту сердцебиение досудебную колеблется беби мразеблоггерша';
		$allowed[] = 'дирижабля дубля волшебную внеблоковый пищеблоку хребта ассеблеров';
		$allowed[] = 'заштрихуйте Хулиан потребную Хулимсунт'; // Хулимсунт — посёлок такой.
		$allowed[] = 'хулахуп ибо хулению';

		foreach($allowed as $s)
			$test->assertEquals($s, self::mask($s, true));

		// Обсценные слова
		$obscene = array('��� ����� ������� ����� ��� �������� �������� ����� ������');
		$obscene[] = '����� ���� ��������� ���� ���� ������ �������� ������� �������� ���� ���� ������';
		$obscene[] = '��� ����� ���� ��� ��������� ������� �£���� ��������� ����ϣ� ����ϣ�� ���� ����� �����������';
		$obscene[] = '����� ����� ��ϣ� ����� ����������� ������ ����';
		$obscene[] = '���������� ������� �������� ����� ����� �����';
		$obscene[] = '������ ������� ������';
		$obscene[] = '��� ����� ����� �������� �������� ������� ����';
		$obscene[] = '���٣�������� ����������� ��������� ��������� �������';

		foreach($obscene as $words)
		{
			foreach(explode(' ', iconv('koi8-r', 'utf-8', $words)) as $w)
			{
				$masked = self::mask($w, true);
				$test->assertNotEquals($w, $masked);
				$test->assertEquals(bors_strlen($w), bors_strlen($masked), "Tested words: '$w' => '$masked'");
			}
		}

		$obscene = explode(' ', 'говна пидоры пидарас мудачьё мудак мудила мудилка мудаки');
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
		$text = 'говно пидоры хлебнуло хребтом сердцебиение учебную';
		echo self::mask($text, true), PHP_EOL;
	}
}
