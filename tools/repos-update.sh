#!/bin/bash

clear

for REPO in *; do
	if [[ -e $REPO/.hg/hgrc ]]; then
		echo -e "\e[1;37m=== $REPO ===\e[0m"
		echo -ne "\033]0;hg push $REPO \007"
		cd $REPO
		hg pull
		hg up
		cd ..
	fi
	if [[ -e $REPO/.git/config ]]; then
		echo -e "\e[1;37m=== $REPO ===\e[0m"
		echo -ne "\033]0;git pull $REPO \007"
		cd $REPO
		git pull
		cd ..
	fi
done

for REPO in *.git; do
	echo -e "\e[1;37m=== $REPO ===\e[0m"
	echo -ne "\033]0;git fetch $REPO \007"
	cd $REPO
	git fetch
	cd ..
done
