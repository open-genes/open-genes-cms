#!/bin/sh
UID=$(id -u)
GID=$(id -g)

mkdir -p ../../logs ../../mysql
OPEN_GENES_UID=$UID:$GID docker-compose up -d
