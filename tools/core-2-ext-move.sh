#!/bin/bash

if [[ "$1" == "" ]]; then
	echo Run $0 file-to-move
	exit
fi

TEMP=/tmp/bors-temp
FILEMAP=/tmp/moved-files.map

pushd ../..

## via http://stackoverflow.com/questions/3643313/mercurial-copying-one-file-and-its-history-to-another-repository

# Create a filemap for the ConvertExtension with the single line:
# include path/to/file

echo include $1 > $FILEMAP

rm $TEMP -rf
mkdir $TEMP
hg init $TEMP

# Then use:
# hg convert path/to/original path/to/temporary --filemap filemap

hg convert bors-core $TEMP --filemap $FILEMAP

# to create the temporary repository. Next, in the target repository, do:
# hg pull -f path/to/temporary

cd bors-ext
hg pull -uf $TEMP

rm -rf $TEMP
unlink $FILEMAP

popd
