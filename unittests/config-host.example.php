<?php

mysql_access('BORS_UNIT_TEST', 'bors-user', 'xxxxxxxxxxxxxxxx');
config_set('mysql_set_names_charset', 'utf8');
config_set('phpunit.skip_db', true);
