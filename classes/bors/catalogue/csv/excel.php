<?php

// http://matf.aviaport.ru/persons/lists/8.csv

class bors_catalogue_csv_excel extends bors_object
{
	function pre_show()
	{
		$ret = parent::pre_show();
		header("Content-type: text/csv");
		return $ret;
	}

	function renderer() { return $this; }
	function render()
	{
		$fields = $this->export_fields();

		$fname = tempnam(config('cache_dir'), 'export-csv-');
		$fp = fopen($fname, 'wt');

		fputcsv($fp, array_keys($fields), ';');

		foreach($this->items() as $x)
		{
			$line = array();
			foreach($fields as $title => $property)
			{
				$v = trim($x->get_ne($property));
//					if(strpos($v, ';') !== false)
//						echo $v;
				$line[] = $v;
			}

			fputcsv($fp, $line, ';');
		}
		fclose($fp);

		$csv = file_get_contents($fname);
		unlink($fname);
		return $csv;
	}
}
