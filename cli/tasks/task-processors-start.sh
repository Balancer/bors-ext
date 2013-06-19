#!/bin/bash

PROCESSORS_COUNT=5

echo Run $PROCESSORS_COUNT processors

trap "pkill -TERM -P $$" SIGINT SIGTERM

for i in $(seq 1 $PROCESSORS_COUNT); do
	./task-processor-loop.sh $i &
done

wait
