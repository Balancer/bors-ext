<?php

class bors_module_breadcrumb_list extends bors_module
{
	function body_engine() { return 'body_php'; }

	function body_template_ext() { return $this->args('template').'.tpl.php'; }

	private $visited_pairs;

	function body_data()
	{
		$this->visited_pairs = array();

		$obj = &$this->id();

        return array(
			'links' => $this->link_line($this->args('show_self', true)),
			'nav_obj' => $obj,
			'delim' => $this->args('delim', ' &#187; '),
		);
    }

    function link_line($show_self = true, &$shown = array())
    {
		$obj = $this->id();
//    	echo "<b>$obj</b>:<br/>url: {$obj->url()}<br/>parents: ".print_r($obj->parent_objects(), true)."<br/><br/>";

		$result = array(array());

		if(!$obj || !$obj->internal_uri())
			return $result;

		if(@$shown[$obj->internal_uri()])
			return $result;

		$shown[$obj->internal_uri()] = true;

		if(!$obj->parents())
			return $result;

		$result = array();
		foreach($obj->parents() as $parent)
		{
			$links = array();

			if($parent == 'http:///')
			{
				debug_hidden_log('internal-errors', "Incorrect parent url for '{$obj}': $parent");
				continue;
			}

			$parent_obj = object_load($parent);
//			echo "p($obj): $parent -> $parent_obj<br/>";
			if(!$parent_obj || $parent_obj->internal_uri() == $obj->internal_uri())
				continue;

//			$shown[$parent_obj->internal_uri()] = true;

			$parent_nav = object_load($this->class_name(), $parent_obj);
			$parent_link_line = $parent_nav->link_line(false, $shown);

			for($i = 0; $i < count($parent_link_line); $i++)
				$parent_link_line[$i][] = $parent_obj;

			$result = array_merge($result, $parent_link_line);
		}

		if(empty($result))
			$result = array(array());

		if($show_self)
			for($i = 0; $i < count($result); $i++)
				$result[$i][] = $obj;

		return $result;
	}
}
