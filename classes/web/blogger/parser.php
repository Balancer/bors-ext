<?php

class web_blogger_parser extends bors_object
{
	static function parse($data)
	{
//		var_dump($data);
		extract($data);
//		file_put_contents('000', $text);



/*
		<table align="center" cellpadding="0" cellspacing="0" class="tr-caption-container" style="margin-left: auto; margin-right: auto; text-align: center;">
		<tbody>
			<tr>
				<td style="text-align: center;">
					<a href="http://3.bp.blogspot.com/-aupkjVNGl84/UUsxmAeqR8I/AAAAAAAAMys/86otU7bRjC4/s1600/IMG_2446.JPG" imageanchor="1" style="margin-left: auto; margin-right: auto;">
						<img border="0" height="480" src="http://3.bp.blogspot.com/-aupkjVNGl84/UUsxmAeqR8I/AAAAAAAAMys/86otU7bRjC4/s640/IMG_2446.JPG" width="640">
					</a>
				</td>
			</tr>
			<tr>
				<td class="tr-caption" style="text-align: center;">
					29 марта 2005-го. Снег лежит практически как и сейчас :)
				</td>
			</tr>
		</tbody>
		</table>
*/
//		$text = preg_replace('!<table[^>]+><tbody><tr><td[^>]+>!');




		$dom= new DOMDocument('1.0', 'UTF-8');
		$dom->loadHTML('<?xml encoding="UTF-8">' . $text);
		$dom->encoding="UTF-8";
		$xpath = new DOMXPath($dom);

		foreach($xpath->query('//table[@class="tr-caption-container"]') as $table_node)
		{
			$x = $xpath->query('tbody/tr', $table_node);
			if(!$x || !$x->item(0) || !$x->item(1))
				continue;

			$td_img_node = $x->item(0);
			$td_desc_node = $x->item(1);

//			echo PHP_EOL,PHP_EOL,$dom->saveHTML($td_img_node),PHP_EOL;

			if($el = $td_img_node->getElementsByTagName('a')->item(0))
				$href = $el->getAttribute('href');
			else
				$href = NULL;

			if($el = $td_img_node->getElementsByTagName('img')->item(0))
				$img  = $el->getAttribute('src');
			else
				$img = NULL;

//			$dom_desc = new DOMDocument('1.0', 'UTF-8');
			$desc = $dom->saveHTML($td_desc_node->getElementsByTagName('td')->item(0));
			$desc = preg_replace('!^<td[^>]+>(.+)</td>$!', '$1', $desc);

			$bb_code = "[img=$img href=$href description=\"".htmlspecialchars(htmlspecialchars(bors_lib_bb::from_html($desc)))."\" htmldecode=1]";

//			var_dump($bb_code);

			$el = $dom->createElement('div', $bb_code);
//			$table_node->parentNode->replaceChild($bb_code, $table_node);
			$table_node->parentNode->replaceChild($el, $table_node);
		}

//		file_put_contents('004', $dom->saveHTML());

		$bb_code = bors_lib_bb::from_dom_tidy($dom, $link)."\n";

//		file_put_contents('003', $bb_code);

		$bb_code = trim("[h]{$title}[/h]\n\n".trim($bb_code));

		return compact('title', 'bb_code', 'tags');
	}
}
