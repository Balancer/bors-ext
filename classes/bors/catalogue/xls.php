<?php

/*
	Изучить:
		phpoffice/phpexcel
		PHPExcel - OpenXML - Read, Create and Write Spreadsheet documents in PHP - Spreadsheet engine
		https://packagist.org/packages/phpoffice/phpexcel
*/

// http://matf.aviaport.ru/persons/lists/8.xls

class bors_catalogue_xls extends bors_object
{
	function __construct($id)
	{
		$this->fname = tempnam(config('cache_dir'), 'export-xls-');
		return parent::__construct($id);
	}

	function pre_show()
	{
		$ret = parent::pre_show();
		$fname = bors_ucfirst($this->nav_name());
		if(!$fname)
			$fname = bors_ucfirst($this->title());

		if(!$fname)
			$fname = $this->class_name();

		header("Content-type: application/ms-excel");
		header('Content-Disposition: attachment; filename="'.$fname.'.xls"');
		return $ret;
	}

	function renderer() { return $this; }
	function render()
	{
		$err_save = ini_get('error_reporting');
		ini_set('error_reporting', $err_save & ~E_NOTICE);

		require_once 'Spreadsheet/Excel/Writer.php';

		$workbook = new Spreadsheet_Excel_Writer($this->fname);
		$workbook->setVersion(8);
//		$workbook->_codepage = 0x04E3; //грязный хак, для писать по русски, http://ru-php.livejournal.com/1219823.html

		$worksheet =& $workbook->addWorksheet(bors_substr(preg_replace('/[^\wа-яА-ЯёЕ \.\,]/us', '-', $this->nav_name()), 0, 30));
//$worksheet->setInputEncoding('ISO-8859-7');

		if(PEAR::isError($worksheet))
			bors_throw($worksheet->getMessage());

		$worksheet->setInputEncoding('utf-8');
//		$worksheet->setHeader('test');

		$fields = $this->export_fields();

		$hf =& $workbook->addFormat(); 
		// Определение шрифта - Helvetica работает с OpenOffice calc тоже... 
		//$hf->setFontFamily('Helvetica'); 
		// Определение жирного текста 
		$hf->setBold();
		// Определение размера текста 
		//$hf->setSize('13'); 
		// Определение цвета текста 
		//$hf->setColor('navy'); 
		// Определения ширину границы основания в "thick" 
		//$hf->setBottom(2); 
		// Определение цвета границы основания
		//$hf->setBottomColor('navy'); 
		// Определения выравнивания в специальное значение 
		//$hf->setAlign('merge'); 

//		$hf->setBgColor('Yellow'); 

		$col = 0;
		foreach(array_values($fields) as $h)
			$worksheet->write(0, $col++, $h, $hf);

		$row = 1;
		foreach($this->items() as $x)
		{
			$col = 0;

			foreach($fields as $property => $title)
				$worksheet->write($row, $col++, trim($x->get_ne($property)));

			$row++;
		}

		$workbook->close();
		ini_set('error_reporting', $err_save);
		$csv = file_get_contents($this->fname);
		unlink($this->fname);
		return $csv;
//		return true;
	}

	function _order_def() { return 'title'; }

	function _where_def()
	{
		$join_class = $this->get('inner_join_filter');
		$join_type = 'inner';
		if(!$join_class)
		{
			$join_class = $this->get('join_counter_class');
			$join_type = 'left';
		}

		if($join_class)
		{
			if(preg_match('/^(\w+)\((\w+)\)$/', $join_class, $m))
			{
				$inner_field = $m[2];
				$join_class = $m[1];
			}
			else
				$inner_field = bors_core_object_defaults::item_name($this->main_class()).'_id';

			$db_name = bors_lib_orm::db_name($join_class);
			$table_name = bors_lib_orm::table_name($join_class);

			if($this->get('counts_in_list'))
			{
				if($join_type == 'inner')
				{
					$where[$join_type.'_join'] = "`$db_name`.`$table_name` ON ({$this->main_class()}.id = $inner_field)";
					$where['group'] = $inner_field;
					$where['*set'] = 'COUNT(*) AS `group_count`';
				}
				else
					$where['*set'] = "'$join_class' AS `b_counter_class`";
			}
			else
				$where[] = "{$this->main_class()}.id IN (SELECT $inner_field FROM `$db_name`.`$table_name`)";

		}
		else
			$this->set_attr('__no_join', true);

		return $where;
	}

	function _title_def()
	{
		$class = $this->get('main_class');
		return $class ? bors_foo($class)->class_title_m() : NULL;
	}

	function _items_def()
	{
		$class_name = $this->get('main_class');
		if(!$class_name)
			bors_throw(ec('Не задано имя класса для экспорта'));

		$where = $this->where();
		$where['order'] = $this->get('order');
//		var_dump($where); exit();
		return bors_each($class_name, $where);
	}
}
