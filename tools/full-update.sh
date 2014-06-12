#!/bin/bash

clear

for dir in *; do
    if [[ -e $dir/.hg/hgrc ]]; then
        echo -e "\e[1;37m=== $dir ===\e[0m"
        echo -ne "\033]0;hg pull $dir \007"
        cd $dir
        hg pull
        hg up
        cd ..
    fi
done
