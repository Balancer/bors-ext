#!/bin/bash

clear

echo Check git and hg
for REPO in 1*; do
	if [ -L $REPO ]; then
		continue
	fi

	if [[ -e $REPO/.hg/hgrc ]]; then
		echo -e "\e[1;30m=== $REPO [hg]  ===\e[0m"
		# echo -ne "\033]0;hg push $REPO \007"
		cd $REPO
		hg -q pull | prerror.sh Ошибка $REPO hg pull
		hg -q up | prerror.sh Ошибка $REPO hg up
		cd ..
	fi
	if [[ -e $REPO/.git/config ]]; then
		echo -e "\e[1;30m=== $REPO [git] ===\e[0m"
		# echo -ne "\033]0;git pull $REPO \007"
		cd $REPO
		git pull -q 2>&1 | prerror.sh Ошибка $REPO git pull
		cd ..
	fi
done

echo
echo Check git bare
for REPO in *.git; do
	if [ -e $REPO ]; then
		echo -e "\e[1;30m=== $REPO [git bare] ===\e[0m"
		# echo -ne "\033]0;git fetch $REPO \007"
		cd $REPO
		git fetch -q 2>&1 | prerror.sh Ошибка $REPO git fetch
		cd ..
	fi
done
