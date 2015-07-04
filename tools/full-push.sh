#!/bin/bash

for REPO in *; do
	if [[ -e $REPO/.hg/hgrc ]]; then
		echo -e "\e[1;37m=== $REPO ===\e[0m"
		echo -ne "\033]0;hg push $REPO \007"
		cd $REPO
		hg ci
		hg push
		cd ..
	fi

	if [[ -e $REPO/.git/config ]]; then
		echo -e "\e[1;37m=== $REPO ===\e[0m"
		echo -ne "\033]0;git push $REPO \007"
		cd $REPO
		git push
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
