#!/bin/bash

EXT=$(dirname $(pwd))
BASE=$(dirname $EXT)
CORE=$BASE/bors-core

cd $BASE

rm bors-demo -rf
rm bors-demo-ext -rf

mkdir bors-demo
hg init bors-demo

mkdir bors-demo-ext
hg init bors-demo-ext

mkdir bors-demo-3rdp
hg init bors-demo-3rdp

hg convert bors-ext bors-demo-ext --filemap $EXT/make/bors-demo.ext.map
hg convert bors-core bors-demo --filemap $EXT/make/bors-demo.core.map
hg convert bors-third-party bors-demo-3rdp --filemap $EXT/make/bors-demo.3rdp.map

#cd bors-demo-ext
#hg mv config.php config
#cd ..

cd bors-demo
hg up
echo Pull bors-demo-ext
echo ------------------
hg pull -f -u ../bors-demo-ext
echo ... merge
hg merge
echo ... commit
hg ci -m Merge
echo Pull bors-demo-3rdp
echo -------------------
hg pull -f -u ../bors-demo-3rdp
echo ... merge
hg merge
echo ... commit
hg ci -m Merge
cd ..

cp $EXT/make/setup.php.demo bors-demo/cli/setup.php

#rm bors-demo-ext -rf
#rm bors-demo-3rdp -rf

echo -e "<?php\nrequire_once 'config-3rd.php';" >> bors-demo/cli/config.php

cd bors-demo/webserver
clear
php run.php
