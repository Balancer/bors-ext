<?php

class phorth_stack
{
	var $_stack = array();

	function pop()
	{
		return array_pop($this->_stack);
	}

	function push()
	{
		return array_push($this->_stack);
	}
}
