#!/bin/sh
UID=$(id -u)
GID=$(id -g)
USAGE="usage: $0 <docker-compose args> [xdebug [client_host]]\nexample: $0 up --build xdebug 192.168.1.100"
COMPOSE_ARGS=`echo $*|awk '{l=NF;if (NF>1 && $(NF-1)=="xdebug") l=NF-2; if (NF>0 && $NF=="xdebug") l=NF-1; if (l>0) for (i=1; i<=l; i++) printf "%s ",$i}'`
CLIENT_HOST=`echo $* |awk '{if (NF>1 && $(NF-1)=="xdebug") print $NF}'`
XDEBUG=`echo $* |awk '{if (NF>0 && $NF=="xdebug") print $NF;if (NF>1 && $(NF-1)=="xdebug") print $(NF-1)}'`
echo "COMPOSE_ARGS '$COMPOSE_ARGS'"
echo XDEBUG $XDEBUG
echo CLIENT_HOST $CLIENT_HOST

[ "$COMPOSE_ARGS" = "" ] && echo $USAGE && exit

if [ "$XDEBUG" != "" -a "$CLIENT_HOST" = "" ]
then
	CLIENT_HOST=`ip -4 -br addr show eth0 |awk '{print $3}' |awk -F '/' '{print $1}'`
	echo CLIENT_HOST ip address autodetected: $CLIENT_HOST
fi

PHP_IMAGE_ALTER=""
[ "$XDEBUG" != "" ] && PHP_IMAGE_ALTER="-xdebug" && echo "Using alternative PHP container image php$PHP_IMAGE_ALTER"


if [ "$COMPOSE_ARGS" = "up " ]
then 
	COMPOSE_ARGS="up -d"
	mkdir -p ../open-genes-logs ../open-genes-mysql
fi

[ "$COMPOSE_ARGS" = "up --no-detach " ] && echo here
[ "$COMPOSE_ARGS" = "up --no-detach " ] && COMPOSE_ARGS="up"
echo "COMPOSE_ARGS '$COMPOSE_ARGS'"

OPEN_GENES_UID=$UID:$GID 
export OPEN_GENES_UID PHP_IMAGE_ALTER CLIENT_HOST

docker-compose $COMPOSE_ARGS
