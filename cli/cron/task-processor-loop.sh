#!/bin/bash

while [[ 1 ]]; do
	bors run task-processor.php
	echo Reload
done
