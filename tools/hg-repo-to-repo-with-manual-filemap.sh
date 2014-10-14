#!/bin/bash

if [[ "$3" == "" ]]; then
	echo Run $0 repo1 repo2 file-map
	exit
fi

FROM="$1"
TO="$2"
FILEMAP="$3"

TEMP=/tmp/bors-temp

## via http://stackoverflow.com/questions/3643313/mercurial-copying-one-file-and-its-history-to-another-repository

rm $TEMP -rf &>/dev/null 2>&1
mkdir $TEMP
hg init $TEMP

hg convert $FROM $TEMP --filemap $FILEMAP

cd $TO
hg pull -uf $TEMP

rm -rf $TEMP
