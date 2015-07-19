#!/bin/bash

LANG=en_US
LANGUAGE=en_US

echo
echo Push repos

for REPO in *; do
	if [ -L $REPO ]; then
		continue
	fi

	if [[ -e $REPO/.hg/hgrc ]]; then
		echo -e "\e[1;30m=== push: $REPO [hg] ===\e[0m"
		echo -ne "\033]0;hg push $REPO \007"
		cd $REPO
		if [[ $(hg stat|grep -v '^\?') ]]; then
			hg cdiff | less -R
			hg ci
		fi
		hg push \
			| grep -Pv '(pushing to |searching for changes|no changes found|adding changesets|adding manifests|adding file changes)' \
			| prerror.sh $REPO hg push
		cd ..
	fi

	if [[ -e $REPO/.git/config ]]; then
		echo -e "\e[1;30m=== push: $REPO [git] ===\e[0m"
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
		echo -e "\e[1;30m=== push: $REPO [git bare] ===\e[0m"
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
