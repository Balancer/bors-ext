#!/bin/bash

PROCESSORS_COUNT=5
DIR=$(dirname $0)

echo Run $PROCESSORS_COUNT processors

trap "pkill -TERM -P $$" SIGINT SIGTERM

for i in $(seq 1 $PROCESSORS_COUNT); do
	$DIR/task-processor-loop.sh $i &
done

wait
