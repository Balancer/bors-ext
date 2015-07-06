<?php

require_once('classes/inc/Xml.php');

/**
	Курс всех валют ЦБР текущий и будущий

	Информация об экспорте данных ЦБР: http://www.cbr.ru/scripts/Root.asp?Prtid=SXML
	Пример использования:
		$x = bors_load('web_cbr_rate_current', strftime('%Y-%m-%d'));
		var_dump($x->today_rates());
		var_dump($x->tomorrow_rates());
*/

class web_cbr_rate_current extends bors_object
{
	function can_be_empty() { return false; }

	function data_load()
	{
		$ch = new bors_cache();
		$url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req='.date('d.m.Y');
		$dom = $ch->get('cbr_rate_xml_parsed', $url);

		if(!$dom)
		{
			$xml = new Xml;
			$content = blib_http::get_cached($url, 3600, true);
			$xml->parse($content);
			$dom = $xml->dom;
			$ch->set($dom, 3600);
		}

		if(!($cur_date = strtotime(@$dom['ValCurs'][0]['Date'])))
		{
			bors_debug::sys_log('cbr-date-error', "Invalid date '".@$dom['ValCurs'][0]['Date']."' in $url");
			return false;
		}

		$valutes = @$dom['ValCurs'][0]['Valute'];

		if(!$valutes)
		{
			bors_debug::sys_log('cbr-date-error', "Can't get CBR valutes for {$cur_date}:".print_r($content, true));
			return false;
		}

		for($days=1; $days<7; $days++)
		{
			$url2 = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req='.strftime('%d.%m.%Y', strtotime(date('Y-m-d', $cur_date)." +$days day"));
			$dom2 = $ch->get('cbr_rate_xml_parsed', $url2);
			if(!$dom2)
			{
				$xml = new Xml;
				$content = blib_http::get_cached($url2, 3600, true);
				$xml->parse($content);
				$dom2 = $xml->dom;
				$ch->set($dom2, 3600);
			}

			$next_date = strtotime(@$dom2['ValCurs'][0]['Date']);
			if($next_date && $cur_date != $next_date)
				break;
		}

		$next_valutes = @$dom2['ValCurs'][0]['Valute'];

		if(!$next_valutes)
		{
			bors_debug::sys_log('cbr-date-error', "Can't get next CBR valutes for {$next_date}:".print_r($content, true));
			return false;
		}

		$cur_rates = array(
			'dmy' => date('d.m.Y', $cur_date),
			'dm' => date('d.m', $cur_date),
			'ts' => $cur_date,
		);

		$next_rates = array(
			'dmy' => date('d.m.Y', $next_date),
			'dm' => date('d.m', $next_date),
			'ts' => $next_date,
		);

		foreach($valutes as $valute)
			$cur_rates[$valute['CharCode']] = str_replace(',', '.', $valute['Value']);

		foreach($next_valutes as $valute)
			$next_rates[$valute['CharCode']] = str_replace(',', '.', $valute['Value']);

		$this->set_attr('today_rates', $cur_rates);
		$this->set_attr('tomorrow_rates', $next_rates);

		return $this->set_is_loaded(true);
	}

	static function __dev()
	{
		$x = bors_load('web_cbr_rate_current', NULL);
		var_dump($x->today_rates());
		var_dump($x->tomorrow_rates());
	}
}
