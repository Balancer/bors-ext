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
	echo processor start
	bors run task-processor.php $1 &
	wait $!
done
