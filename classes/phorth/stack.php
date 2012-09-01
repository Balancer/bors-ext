<?php

class phorth_stack
{
	var $_stack = array();

	function pop()
	{
		return array_pop($this->_stack);
	}

	function push(phorth_word $x)
	{
		array_push($this->_stack, $x);
		return $x;
	}
}
