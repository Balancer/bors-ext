#!/bin/bash

LANG=en_US.utf8
LANGUAGE=en_US.utf8

pushd vendor/balancer > /dev/null

for REPO in *; do

	if [[ -e $REPO/.hg/hgrc ]]; then
		echo -e "\e[1;30m=== sync $REPO [hg] ===\e[0m"
		cd $REPO
		hg pull \
			| grep -Pv '(pulling from|searching for changes|no changes found|to get a working copy|adding changesets|adding manifests|adding file changes)' \
			| prerror.sh $REPO hg pull
		hg up \
			| grep -v '0 files updated, 0 files merged, 0 files removed, 0 files unresolved' \
			| prerror.sh $REPO hg up
		if [[ $(hg stat) ]]; then
			hg cdiff | less -R
			hg ci
		fi
		hg push \
			| grep -Pv '(pushing to |searching for changes|no changes found|adding changesets|adding manifests|adding file changes)' \
			| prerror.sh $REPO hg push
		cd ..
	fi

	if [[ -e $REPO/.git/config ]]; then
		echo -e "\e[1;30m=== sync $REPO [git] ===\e[0m"
		echo -ne "\033]0;git pull $REPO \007"
		cd $REPO
		git pull -q | prerror.sh Ошибка $REPO git pull
		git commit -a -q
		git push -q | prerror.sh Ошибка $REPO git push
		cd ..
	fi

done

popd > /dev/null

composer update

# sudo rm /tmp/bors-cache/* -rf
