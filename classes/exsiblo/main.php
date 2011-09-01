<?php

class exsiblo_main extends bors_paginated
{
	// Возвращаемое этим методом будет считаться заголовком страницы
	function title() { return 'Мой блог'; }

	// Это — класс списка выводимых объектов:
	function main_class() { return 'exsiblo_blog'; }

	// Порядок сортировки: укажем обратную сортировку по дате
	function order() { return '-create_time'; }

	// Это признак того, что класс будет искаться сам, без ручной привязки
	// к маске URL. В нашем случае — по адресу /exsiblo/
	function is_auto_url_mapped_class() { return true; }
}
