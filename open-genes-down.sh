#!/bin/sh
UID=$(id -u)
GID=$(id -g)

OPEN_GENES_UID=$UID:$GID docker-compose down
