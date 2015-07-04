#!/bin/bash

pushd vendor/balancer > /dev/null

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
		echo -ne "\033]0;git pull $REPO \007"
		cd $REPO
		git pull
		git push
		cd ..
	fi

done

popd > /dev/null

composer update
