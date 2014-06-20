#!/bin/bash

PHPUNIT="$(dirname $(dirname $(dirname $(pwd))))/phpunit/phpunit/phpunit"

clear
if [ -e ~/bin/phpunit.phar ]; then
	~/bin/phpunit.phar unittests-run.php
else
	$PHPUNIT unittests-run.php
fi

