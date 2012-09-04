<?php

// Базовый класс объектов. В общем случае все объекты на стеке — наследники этого класса.

class phorth_object
{
	var $_value = NULL;

	function value() { return $this->_value(); }
}
