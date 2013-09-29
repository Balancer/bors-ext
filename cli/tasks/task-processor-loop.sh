#!/bin/bash

DIR=$(dirname $0)

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
	bors run $DIR/task-processor.php $1 &
	wait $!
done
