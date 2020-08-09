#!/bin/sh
UID=$(id -u)
GID=$(id -g)

mkdir -p ../open-genes-logs ../open-genes-mysql
OPEN_GENES_UID=$UID:$GID docker-compose up -d
