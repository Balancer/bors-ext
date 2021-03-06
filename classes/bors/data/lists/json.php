<?php

class bors_data_lists_json extends bors_json
{
	function can_read() { return bors_lib_object::get_foo($this->list_class_name(), 'can_read'); }
	function access() { return bors_lib_object::get_foo($this->list_class_name(), 'access'); }

	function list_class_name()
	{
		$list_class_name = $this->id();
		if(!preg_match('/^\w+$/', $list_class_name))
			$list_class_name = bors()->request()->data('class');

		return $list_class_name;
	}

	function data()
	{
		file_put_contents('/tmp/00json.log', print_r($_SERVER, true), FILE_APPEND);

		$list_class_name = $this->list_class_name();

//	q=Шере&p=1&s=10&contentType=application/json; charset=utf-8

		$r = bors()->request();

		$find = bors_find($list_class_name);

		if($q = $r->data('q'))
		{
			if($search_properties = $r->data('search'))
				$find->like_any_id(explode(',', $search_properties), $q);
			else
				$find->like_id('title', $q);
		}
//			file_put_contents('/tmp/json.log', $q, FILE_APPEND);

		$total = $find->count();

		if($p = bors()->request()->data('p'))
			$find->page($p, bors()->request()->data('s'));
		else
			$find->limit(200);

		if($w = $r->data('where'))
		{
			if(!is_array($w))
				$w = json_decode($w, true);
//			file_put_contents('/tmp/json.log', print_r($w, true));
//			file_put_contents('/tmp/json.log', $w.' == '.print_r(json_decode($w, true), true));
			foreach($w as $key => $value)
				$find->where($key, $value);
		}

		$find->order($r->data('order', 'title'));

		$result = array();

		if($tpl = $r->data('tpl'))
		{
			$tpl = json_decode($tpl, true);

			if(!$r->data('skip_null'))
			{
				$r2 = array();
				foreach($tpl as $ret_f => $obj_f)
					if($obj_f == 'id')
						$r2[$ret_f] = 'NULL';
					else
						$r2[$ret_f] = '';

				$result[] = $r2;
			}

			foreach($find->all() as $x)
			{
				$r2 = array();

				foreach($tpl as $ret_f => $obj_f)
				{
					// Если в поле для вывода простое имя, то это имя возвращаемого значения.
					if(preg_match('/^\w+$/', $obj_f))
						$r2[$ret_f] = $x->get($obj_f);
					// Если несколько имён, перечисленных через запятую, то возвращаем первое не пустое
					elseif(preg_match('/^(\w+,)*\w+$/', $obj_f))
					{
						$coalesce_res = NULL;

						foreach(explode(',', $obj_f) as $coalesce_f)
							if(($coalesce_res = $x->get($coalesce_f)))
								break;

						if(!$coalesce_res)
							$coalesce_res = 'NULL';

						$r2[$ret_f] = $coalesce_res;
					}
					// Иначе рассматриваем строку с возвращаемым значением как шаблон, где %имя% заменяется на значение объекта.
					else
						$r2[$ret_f] = preg_replace_callback('/%(\w+)%/', function($m) use ($x) { return $x->get($m[1]); }, $obj_f);
				}

				$result[] = $r2;
			}
		}
		else
			foreach($find->all() as $x)
				$result[] = array('id' => $x->id(), 'name' => $x->title());

		if($r->data('results') == 'root')
			return $result;

		if($rn = $r->data('results'))
			return array($rn => $result);

		return array('results' => $result, 'total' => $total);
	}
}
