<?php

/**
	Сокрытие части текста сообщения с возможностью показа кликом мышкой по сопровождающему тексту.
	Скрытый текст шифруется, чтобы избежать индексации поисковыми системами, но доступен
	для любого интерактивного JS-браузера. Осторожно, боты Google сегодня умеют
	частично исполнять JS.

	Частичное ограничение — внутри тега используется только механизм
	разметки lcml_bb (чистый BB-код)

	Примеры использования:

		[spoiler]Это скрытый текст[/spoiler]

		[spoiler|Нажмите, чтобы увидеть текст]Скрытый текст[/spoiler]

	Ссылка с примером: http://www.balancer.ru/g/p3339354
*/

class lcml_tag_pair_spoiler extends bors_lcml_tag_pair
{
	function html($txt, &$params = array())
	{
		// Нужно использовать класс Base64
		$result = $this->use_js('/_bors/js/bors.js');

		$id = time().rand();

		$lcml = $params['lcml'];
		$saved_level = $lcml->p('level');
		$lcml->set_p('level', 0);
		$html = lcml_bb(trim($txt));
		$lcml->set_p('level', $saved_level);

		$desc = @$params['description'];

		if($desc)
			$desc .= '&nbsp;';

		return $result . "<a href=\"#\" class=\"spoiler\" onClick=\""
			."var d=(el=(document.getElementById('$id'))).style;"
			."if(d.display==''){d.display='none';el.innerHTML=Base64.encode(el.innerHTML);"
				."(document.getElementById('_$id')).innerHTML='показать'}"
			."else{el.innerHTML=Base64.decode(el.innerHTML);d.display='';"
				."(document.getElementById('_$id')).innerHTML='скрыть'};"
			."return false;\">".$desc."[<span id=\"_$id\">показать</span>]</a>"
			."<div id=\"$id\" style=\"display: none; border: 1px dotted; margin: 0px 10px 4px 0; padding: 2px;\">"
			.base64_encode($html)."</div>\n";
	}
}
