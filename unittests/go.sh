#!/bin/bash

clear
if [ -e ~/bin/phpunit.phar ]; then
	~/bin/phpunit.phar unittests-run.php
else
	phpunit unittests-run.php
fi

