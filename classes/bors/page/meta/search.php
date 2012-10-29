<?php

class bors_page_meta_search extends bors_page_meta_main
{
	function q() { return (urldecode(@$_GET['q'])); }
	function qfc()
	{
		$fc = urldecode(@$_GET['fc']);

		if(strlen($fc) == 2)
			$fc = ec($fc);

		return $fc;
	}

    function title() { return ec('Результат поиска «').$this->q().ec('»: '); }

    function nav_name() { return ec('«'). $this->q() .ec('»'); }

	function pre_parse()
	{
		if(!$this->qfc() && !$this->q())
			return go('/directory/airports/');

		return parent::pre_parse();
	}

	function pre_show()
	{
		template_noindex();

		$airports = $this->_airports();

		if(sizeof($airports) == 1)
			return go($airports[0]->url());

		return false;
	}

	function _airports()
	{
		if($this->__havec('_airports'))
			return $this->__lastc();

		$where = array();
		$where['order'] = 'name_rus';

		$db = new driver_mysql(config('aviaport_db'));
		if(($q = mysql_real_escape_string($this->q(), $db->link())))
			$where[] = "(name_rus LIKE '%$q%' OR ICAO_rus LIKE '$q')";

		if(($fc = $this->qfc()))
			$where['LEFT(name_rus, 1) ='] = $fc;

		return $this->__setc(objects_array('aviaport_directory_airport', $where));
	}

	function body_data()
	{
		$db = new driver_mysql(config('aviaport_db'));

		return array_merge(parent::body_data(), array(
			'airports' => $this->_airports(),
			'letters' => $db->select_array('airports', 'DISTINCT LEFT(name_rus, 1) as fc', array('order' => 'fc')),
			'q' => $this->q(),
		));
    }
}
