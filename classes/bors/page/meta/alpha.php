<?php

class bors_page_meta_alpha extends bors_page_meta_search
{
    function title() { return ec('Алфавитный указатель ').$this->foo_object()->class_title_rpm().ec(': «').$this->qfc() . ec('»'); }

    function nav_name() { return ec('алфавит: «') . $this->qfc() . ec('»'); }

	function body_data()
	{
		return array_merge(parent::body_data(), array(
		));
    }

	function where()
	{
		return array(
			'trademark_rus LIKE "'.$this->qfc().'%"',
		);
	}
}
