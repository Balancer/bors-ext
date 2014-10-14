#!/bin/bash

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

for REPO in *.git; do
	echo -e "\e[1;37m=== $REPO ===\e[0m"
	echo -ne "\033]0;git push $REPO \007"
	cd $REPO
	git push
	cd ..
done
