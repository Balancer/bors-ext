<?php

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
		if(!(class_exists('PHPExcel')))
			bors_throw("Отсутствует класс PHPExcel. Настройте Composer на загрузку пакета phpoffice/phpexcel");

		$ret = parent::pre_show();
		$fname = bors_ucfirst($this->nav_name());
		if(!$fname)
			$fname = bors_ucfirst($this->title());

		if(!$fname)
			$fname = $this->class_name();

		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		header('Content-Disposition: attachment; filename="'.$fname.'.xls"');

		return $ret;
	}

	function renderer() { return $this; }
	function render()
	{
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("AviaPort.Ru")
			 ->setLastModifiedBy("AviaPort.Ru")
			 ->setTitle($this->title())
//			 ->setSubject("Office 2007 XLSX Test Document")
//			 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
//			 ->setKeywords("office 2007 openxml php")
//			 ->setCategory("Test result file")
		;

		$sheet = $objPHPExcel->setActiveSheetIndex(0);

		$fields = $this->export_fields();

		$col = 0;
		foreach(array_values($fields) as $h)
			$sheet->setCellValueByColumnAndRow($col++, 1, $h);

		// Раскраску см. http://stackoverflow.com/questions/6773272/set-background-cell-color-in-phpexcel
		$objPHPExcel->getActiveSheet()->getStyle("A1:Z1")->getFont()->setBold(true);

		$row = 2;
		foreach($this->items() as $x)
		{
			$col = 0;

			foreach($fields as $property => $title)
				$sheet->setCellValueByColumnAndRow($col++, $row, trim($x->get_ne($property)));

			$row++;
		}

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle(bors_substr(preg_replace('/[^\wа-яА-ЯёЕ \.\,]/us', '-', $this->nav_name()), 0, 30));

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save($this->fname);

		$csv = file_get_contents($this->fname);
		unlink($this->fname);
		return $csv;
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
