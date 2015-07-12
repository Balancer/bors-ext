#!/bin/bash

# http://stackoverflow.com/questions/1507674/how-to-add-timestamp-to-stderr-redirection
# Добавляет дату к каждой строке вывода
# ( echo a ; sleep 5 ; echo b ; sleep 2 ; echo c ) | ./predate.sh

while read line ; do
	echo "$(date): ${line}"
done
