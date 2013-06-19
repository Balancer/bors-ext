#!/bin/bash

cleanup()
{
	echo
	echo -n processor stop
	kill -s SIGTERM $!
	exit 0
}

trap cleanup SIGINT SIGTERM

while true; do
	echo
	echo -n processor start
	bors run task-processor.php &
	wait $!
done
