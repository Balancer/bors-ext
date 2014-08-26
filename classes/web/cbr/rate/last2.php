<?php

require_once('classes/inc/Xml.php');

/**
	Курс всех валют ЦБР на выбранную дату и предыдущий день

	Информация об экспорте данных ЦБР: http://www.cbr.ru/scripts/Root.asp?Prtid=SXML
	Пример использования:
		$x = bors_load('web_cbr_rate_last2', strftime('%Y-%m-%d'));
		var_dump($x->last_day_rate());
		var_dump($x->prev_day_rate());
*/

class web_cbr_rate_last2 extends bors_object
{
	function can_be_empty() { return false; }

	function data_load()
	{
		$ch = new bors_cache();
		$url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req='.strftime('%d.%m.%Y', strtotime($this->id()));
		$dom = $ch->get('cbr_rate_xml_parsed', $url);

		if(!$dom)
		{
			$xml = new Xml;
			$content = blib_http::get_cached($url, 3600, true);
			$xml->parse($content);
			$dom = $xml->dom;
			$ch->set($dom, 3600);
		}

		if(!($last1 = strtotime(@$dom['ValCurs'][0]['Date'])))
		{
			debug_hidden_log('cbr-date-error', "Invalid date '".@$dom['ValCurs'][0]['Date']."' in $url");
			return false;
		}

		$valutes = @$dom['ValCurs'][0]['Valute'];

		if(!$valutes)
		{
			echo "Can't get CBR for {$this->id()}:<br/>\n";
			print_d($content);
			return false;
		}

		for($days=1; $days<7; $days++)
		{
			$url2 = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req='.strftime('%d.%m.%Y', strtotime(date('Y-m-d', $last1)." -$days day"));
			$dom2 = $ch->get('cbr_rate_xml_parsed', $url2);
			if(!$dom2)
			{
				$xml = new Xml;
				$content = blib_http::get_cached($url2, 3600, true);
				$xml->parse($content);
				$dom2 = $xml->dom;
				$ch->set($dom2, 3600);
			}

			$last2 = strtotime(@$dom2['ValCurs'][0]['Date']);
			if($last2 && $last1 != $last2)
				break;
		}

		$valutes2 = @$dom2['ValCurs'][0]['Valute'];

		if(!$valutes2)
		{
			echo "Can't get CBR for {$this->id()}:<br/>\n";
			print_d($content);
			return false;
		}

		$rates1 = array('dmy' => date('d.m.Y', $last1), 'time' => $last1);
		$rates2 = array('dmy' => date('d.m.Y', $last2), 'time' => $last2);

		foreach($valutes as $valute)
			$rates1[$valute['CharCode']] = floatVal(str_replace(',', '.', $valute['Value']));

		foreach($valutes2 as $valute)
			$rates2[$valute['CharCode']] = floatVal(str_replace(',', '.', $valute['Value']));

		$this->set_attr('last_day_rate', $rates1);
		$this->set_attr('prev_day_rate', $rates2);

		return $this->set_is_loaded(true);
	}

	static function __dev()
	{
		$x = bors_load('web_cbr_rate_last2', strftime('%Y-%m-%d'));
		var_dump($x->last_day_rate());
		var_dump($x->prev_day_rate());
	}
}
