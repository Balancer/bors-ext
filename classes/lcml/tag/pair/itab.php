<?php

/**
	Таблица indent-типа
*/

class lcml_tag_pair_itab extends bors_lcml_tag_pair
{
	function html($text, &$params = array())
	{
		$text = str_replace("	", "    ", $text);
//		print_r($text); echo "\n";
		$cols_map = array();
		$row = 0;
		$prev_indent = NULL;
		$cell_text = array();

		$cols = 0;
		$col = -1;

		require_once 'HTML/Table.php';
		$table = new HTML_Table();

		foreach(explode("\n", $text) as $s)
		{
			if(!preg_match('/^(\s*)(\S+.*$)/', $s, $m))
				continue;

			$indent = strlen($m[1]);
//			echo "i=$indent, prev=$prev_indent\n";

			if(!array_key_exists($indent, $cols_map))
				$cols_map[$indent] = $cols++;

			$col = $cols_map[$indent];

			if($indent != $prev_indent && !is_null($prev_indent))
			{
//				var_dump($cols_map);
				self::add_cell($table, $cell_text, $row, $c = $cols_map[$prev_indent]);
				$cell_text = array();
				if($col == 0)
					$row++;
			}

			$prev_indent = $indent;
			$cell_text[] = $m[2];
		}

		if($cell_text)
			self::add_cell($table, $cell_text, $row, $col);

		$html = $table->toHTML();
//		echo $html;
		return $html;
	}

	static function add_cell($table, $text, $row, $col)
	{
		$text = trim(join("\n", $text));

		if(preg_match('/^([!])(.+)$/', $text, $m))
		{
			$text = $m[2];
			$mod = $m[1];
		}
		else
			$mod = false;

		if(preg_match('/[^\wа-яА-ЯёЁ]/u', $text))
			$text = lcml($text);

//		echo "{$row},{$col}: [$text]\n";
		if($mod == '!')
			$table->setHeaderContents($row, $col, $text);
		else
			$table->setCellContents($row, $col, $text);
	}

	static function __unit_test($suite)
	{
		$bbtext = "!Самолёт
	!Нормальная взлётная масса, кг
Су-27
	22500
МиГ-29
	[red]15180[/red]
";


		$bbcode = "[itab]{$bbtext}[/itab]";

		$x = new lcml_tag_pair_itab(NULL);
		$direct_html = $x->html($bbtext);

		$suite->assertRegExp('!<tr>.*<th>Самолёт</th>.*<th>Нормальная взлётная масса, кг</th>.*</tr>.*<tr>.*<td>Су-27</td>!s', $direct_html);
		$suite->assertRegExp('!<tr>.*<td>Су-27</td>.*<td>22500</td>.*</tr>.*<tr>.*<td>МиГ-29</td>!s', $direct_html);
		$suite->assertRegExp('!<td>.+red.+15180.*</td>!', $direct_html);
	}
}
