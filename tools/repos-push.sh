#!/bin/bash

clear

for REPO in *; do
	if [[ -e $REPO/.hg/hgrc ]]; then
		echo -e "\e[1;30m=== $REPO ===\e[0m"
		echo -ne "\033]0;hg push $REPO \007"
		cd $REPO
		hg -q ci | prerror.sh Ошибка $REPO hg ci
		hg -q push | prerror.sh Ошибка $REPO hg push
		cd ..
	fi

	if [[ -e $REPO/.git/config ]]; then
		echo -e "\e[1;30m=== $REPO ===\e[0m"
		echo -ne "\033]0;git push $REPO \007"
		cd $REPO
		git push -q 2>&1 | prerror.sh Ошибка $REPO git push
		cd ..
	fi
done

echo
echo Push to git bare
for REPO in *.git; do
	if [ -e $REPO ]; then
		echo -e "\e[1;30m=== $REPO ===\e[0m"
		echo -ne "\033]0;git push $REPO \007"
		cd $REPO
		git push -q 2>&1 | prerror.sh Ошибка $REPO git push
		cd ..
	fi
done


echo
echo Do hg-2-git
for REPO in *; do
	if [ -e hg-2-git/$REPO.sh ]; then
		cd hg-2-git
		./$REPO.sh
	fi
done
