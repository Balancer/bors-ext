<?php

function smarty_function_bootstrap_nav_bar($params, &$smarty)
{
	$nav_bar = @$params['bar'];
	if(!$nav_bar)
		return '';

	$html = array();

	foreach($nav_bar as $title => $items)
	{
		// проход по элементам навбара
		// Если это подменю
		if(is_array($items))
		{
			if(!empty($items['url']))
			{
				$url = $items['url'];
				unset($items['url']);
			}
			else
				$url = '#';

			$html[] = "<li class=\"dropdown\">";
			$html[] = "<a href=\"{$url}\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">{$title} <b class=\"caret\"></b></a>";
			$html[] = "<ul class=\"dropdown-menu\">";
			$html[] = smarty_function_bootstrap_nav_bar_submenu($items);
			$html[] = "</ul></li>";
		}
		else
			$html[] = "<li><a href=\"{$items}\">{$title}</a></li>";
	}

	echo join("\n", $html);
}

function smarty_function_bootstrap_nav_bar_submenu($menu)
{
	$html = array();

	foreach($menu as $title => $items)
	{
		//	проход по вертикальному меню
		//	Если в нашем пунке есть подменю
		if(is_array($items))
		{
			// Если указан параметр url, то это — прямая ссылка на корневой элемент меню
			if(@$items['url'])
			{
				$url = $items['url'];
				unset($items['url']);
			}
			else
				$url = '#';

			// Рисуем подменю
			$html[] = "<li class=\"dropdown-submenu\"><a href=\"{$url}\" tabindex=\"-1\">{$title}</a>";
			$html[] = "<ul class=\"dropdown-menu\">";
			// Рекурсивно
			$html[] = smarty_function_bootstrap_nav_bar_submenu($items);
			$html[] = "</ul></li>";
		}
		else
		{
			// Это обычный пункт меню
			// Преобразуем ссылки из одних символов в ссылки на корневой элемент сайта
			$items = preg_replace('/^(\w+)$/', '/$1/', $items);
			$html[] = "<li><a href=\"{$items}\">{$title}</a></li>";
		}
	}

	return join("\n", $html);
}
