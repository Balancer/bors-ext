#!/bin/bash

# http://stackoverflow.com/questions/1507674/how-to-add-timestamp-to-stderr-redirection
# Добавляет сообщение об ошибке перед каждой строкой вывода
# ( echo a ; sleep 5 ; echo b ; sleep 2 ; echo c ) | ./prepend.sh test:

PROMPT_SHOWN="no"

while read line ; do
	if [[ ${PROMPT_SHOWN} == "no" && $line ]]; then
		echo -en "\e[1;31m"
		echo -n $*
		echo -e "\e[0m"

		PROMPT_SHOWN="yes"
	fi

	echo ${line}
done
