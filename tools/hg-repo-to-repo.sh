#!/bin/bash

if [[ "$3" == "" ]]; then
	echo Run $0 repo1 repo2 file-to-move
	exit
fi

FROM="$1"
TO="$2"
TEMP=/tmp/bors-temp
FILEMAP=/tmp/moved-files.map

## via http://stackoverflow.com/questions/3643313/mercurial-copying-one-file-and-its-history-to-another-repository

echo include $3 > $FILEMAP

rm $TEMP -rf &>/dev/null 2>&1
mkdir $TEMP
hg init $TEMP

hg convert $FROM $TEMP --filemap $FILEMAP

cd $TO
hg pull -uf $TEMP

rm -rf $TEMP
unlink $FILEMAP
