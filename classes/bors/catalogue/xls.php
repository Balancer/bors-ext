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
		$ret = parent::pre_show();
		header("Content-type: application/ms-excel");
		return $ret;
	}

	function renderer() { return $this; }
	function render()
	{

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
		foreach(array_keys($fields) as $h)
			$worksheet->write(0, $col++, $h, $hf);

		$row = 1;
		foreach($this->items() as $x)
		{
			$col = 0;

			foreach($fields as $title => $property)
				$worksheet->write($row, $col++, trim($x->get_ne($property)));

			$row++;
		}

		$workbook->close();
		$csv = file_get_contents($this->fname);
		unlink($this->fname);
		return $csv;
//		return true;
	}
}
