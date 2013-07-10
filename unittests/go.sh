#!/bin/bash

PHPUNIT="$(dirname $(dirname $(pwd)))/bors-third-party/composer/vendor/phpunit/phpunit/phpunit.php"

clear
if [ -e ~/bin/phpunit.phar ]; then
	~/bin/phpunit.phar unittests-run.php
else
	$PHPUNIT unittests-run.php
fi

