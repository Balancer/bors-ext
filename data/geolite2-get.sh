#!/bin/bash

wget http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz -O geolite2/GeoLite2-City.mmdb.gz
zcat geolite2/GeoLite2-City.mmdb.gz > geolite2/GeoLite2-City.mmdb

wget http://geolite.maxmind.com/download/geoip/database/GeoLite2-Country.mmdb.gz -O geolite2/GeoLite2-Country.mmdb.gz
zcat geolite2/GeoLite2-Country.mmdb.gz > geolite2/GeoLite2-Country.mmdb
