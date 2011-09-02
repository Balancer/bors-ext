#!/bin/bash

EXT=$(dirname $(pwd))
BASE=$(dirname $EXT)
CORE=$BASE/bors-core

cd $BASE

rm bors-demo -rf
mkdir bors-demo
hg init bors-demo

hg convert bors-core bors-demo --filemap $EXT/make/bors-demo.core.map

pushd bors-demo
hg up

for i in ext third-party tutorial; do
	rm ../bors-demo-$i -rf

	mkdir ../bors-demo-$i
	hg init ../bors-demo-$i

	hg convert ../bors-$i ../bors-demo-$i --filemap $EXT/make/bors-demo.$i.map

	echo === Pull bors-demo-$i
	hg pull -f -u ../bors-demo-$i
	echo ... merge
	hg merge
	echo ... commit
	hg ci -m Merge
#	rm ../bors-demo-$i -rf
done

popd

cp $EXT/make/setup.php.demo bors-demo/cli/setup.php
cp -r $EXT/make/jquery-local bors-demo/webserver/htdocs

# echo -e "<?php\nrequire_once 'config-3rd.php';" >> bors-demo/ext/cli/config.php

cat ext.config.inc.demo >> bors-demo/ext/config.php

cd bors-demo/webserver
clear
(sleep 1; brun http://localhost:8800/)&
php run.php
