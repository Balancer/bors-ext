<?php

class phorth_objects_string extend phorth_object
{
	function names()
	{
		return array(
			'+' => 'plus',
		);
	}

	function parse($value) { return (string) $value; }

	function plus($string2, $stack)
	{
		return $this->parse($stack->pop()) . $string2;
	}
}
