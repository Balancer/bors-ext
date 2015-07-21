#!/bin/bash

export LANG=en_US
export LANGUAGE=en_US

echo
echo Check git and hg

for REPO in *; do
	if [ -L $REPO ]; then
		continue
	fi

	if [[ -e $REPO/.hg/hgrc ]]; then
		echo -e "\e[1;30m=== pull $REPO [hg]  ===\e[0m"
		# echo -ne "\033]0;hg push $REPO \007"
		cd $REPO
		hg pull \
			| grep -Pv '(pulling from|searching for changes|no changes found|adding changesets|adding manifests|adding file changes|to get a working copy)' \
			| prerror.sh $REPO hg pull
		hg up \
			| grep -Pv '(0 files updated, 0 files merged, 0 files removed, 0 files unresolved)' \
			| prerror.sh $REPO hg up
		cd ..
	fi
	if [[ -e $REPO/.git/config ]]; then
		echo -e "\e[1;30m=== pull $REPO [git] ===\e[0m"
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
		echo -e "\e[1;30m=== pull $REPO [git bare] ===\e[0m"
		# echo -ne "\033]0;git fetch $REPO \007"
		cd $REPO
		git fetch -q 2>&1 | prerror.sh Ошибка $REPO git fetch
		cd ..
	fi
done

echo
echo Do hg-git
for REPO in *; do
	if [ -e hg-2-git/$REPO-github ]; then
		cd $REPO
		pwd
		hg pull file://$PWD/hg-2-git/$REPO-github
		hg up
	fi
done
