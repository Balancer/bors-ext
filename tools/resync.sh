#!/bin/bash

pushd vendor/balancer

for dir in *; do
	if [[ -e $dir/.hg/hgrc ]]; then
		echo -e "\e[1;37m=== $dir ===\e[0m"
		echo -ne "\033]0;hg push $dir \007"
		cd $dir
		hg ci
		hg push
		cd ..
	fi
done

popd

composer update
