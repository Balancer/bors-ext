<?php

// https://github.com/maxmind/GeoIP2-php
// http://dev.maxmind.com/geoip/geoip2/geolite2/
// http://dev.maxmind.com/geoip/geoip2/downloadable/#MaxMind_APIs
// symfony/event-dispatcher suggests installing symfony/dependency-injection ()
// symfony/event-dispatcher suggests installing symfony/http-kernel ()

require '../../bors-core/init.php';

use GeoIp2\Database\Reader;

$reader = new Reader(BORS_EXT.'/data/geolite2/GeoLite2-City.mmdb');

// Replace "city" with the appropriate method for your database, e.g.,
// "country".
$record = $reader->city('95.31.43.16');

print($record->country->isoCode . "\n"); // 'US', 'RU'
print($record->country->name . "\n"); // 'United States', 'Russia'
var_dump($record->country->names); // '美国', 'ru' => 'Россия'

print($record->mostSpecificSubdivision->name . "\n"); // 'Minnesota', 'Moscow'
print($record->mostSpecificSubdivision->isoCode . "\n"); // 'MN', 'MOW'

print($record->city->name . "\n"); // 'Minneapolis', 'Moscow'
var_dump($record->city->names); // 'ru' => 'Москва'

print($record->postal->code . "\n"); // '55455', ''

print($record->location->latitude . "\n"); // 44.9733; 55,7522
print($record->location->longitude . "\n"); // -93.2323; 37,6156
