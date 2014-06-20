#!/bin/bash

clear
../../../phpunit/phpunit/phpunit --colors --stop-on-error $* unittests-run.php

