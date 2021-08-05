#!/bin/sh
docker run --volume `pwd`/app:/var/www -it cms_cms php vendor/bin/codecept run
