<?php

class phorth
{
	var $_stream = NULL;
	var $_in = 0;

	function exec($code)
	{
		$this->_stream = trim($code);
		$this->_in = 0;
		$this->_exec();
	}

	function _exec()
	{
		while($str_word = $this->next_word("\s+"))
		{
			$obj_word = $this->find($str_word);

			if($obj_word)
				$obj_word->exec();

		}
	}

	function next_word($delim)
	{
		if($this->_in >= bors_strlen($this->_stream))
			return NULL;

		$x = preg_split("/$delim/", substr($this->_stream, $this->_in));
		$pos = bors_strpos($this->_stream, $x[0], $this->_in);
		if($pos === false)
			bors_throw("Position error");

		$this->_in =  $pos + bors_strlen($x[0]);

		return $x[0];
	}
}
