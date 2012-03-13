<?php

require_once('classes/inc/Xml.php');

/**
	Курс заданной валюты ЦБР на выбранную дату

	Информация об экспорте данных ЦБР: http://www.cbr.ru/scripts/Root.asp?Prtid=SXML
	Пример использования:
		$x = bors_load('web_cbr_rate_day', strftime('%Y-%m-%d/EUR'));
		echo "Сегодня курс Евро: {$x->rate()} руб.";
*/

class web_cbr_rate_day extends bors_object
{
	private $code;
	private $date;

	function __construct($id)
	{
		// Идентификатор вида «2012-03-13/USD»
		list($this->date, $this->code) = explode('/', $id);
		parent::__construct($id);
	}

	function init()
	{
		$xml = &new Xml;
		$content = file_get_contents('http://www.cbr.ru/scripts/XML_daily.asp?date_req='.strftime('%d.%m.%Y', strtotime($this->date)));
		$xml->parse($content);

		if(!($site_date = strtotime($xml->dom['ValCurs'][0]['Date'])))
		{
			debug_hidden_log('cbr-date', "Invalid date {$xml->dom['ValCurs'][0]['Date']}");
			return;
		}

		$this->set_attr('site_date', strftime('%Y-%m-%d', $site_date));

		$valutes = @$xml->dom['ValCurs'][0]['Valute'];

		if(!$valutes)
		{
			echo "Can't get CBR for {$this->date}:<br/>\n";
			print_d($content);
			return;
		}

		foreach($valutes as $valute)
			if($valute['CharCode'] == $this->code)
				return $this->set_attr('rate', floatVal(str_replace(',', '.', $valute['Value'])));
	}
}
