<?php

function lp_spoiler($txt,$params)
{
	$id = time().rand();
	return "<a href=\"#\" class=\"spoiler\" onClick=\"var d=(el=(document.getElementById('$id'))).style; if(d.display==''){d.display='none';el.innerHTML=Base64.encode(el.innerHTML);(document.getElementById('_$id')).innerHTML='показать'}else{el.innerHTML=Base64.decode(el.innerHTML);d.display='';(document.getElementById('_$id')).innerHTML='скрыть'}; return false;\">".@$params['description']."&nbsp[<span id=\"_$id\">показать</span>]</a><div id=\"$id\" style=\"display: none; border: 1px dotted; margin: 0px 10px 4px 20px; padding: 2px;\">".base64_encode(lcml($txt))."</div>\n";
}
