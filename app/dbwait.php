<?php

list($script,$hostname,$port,$username,$password,$database,$timeout)=$argv;

$link = mysqli_init();
mysqli_options($link, MYSQLI_OPT_CONNECT_TIMEOUT, 1);

$start=time();
if (empty($timeout)) $timeout=30;
print "waiting for database to come online (${timeout}s) ...";

while (!($res=@mysqli_real_connect($link, $hostname, $username, $password, $database, $port)) && time()<$start+$timeout)
{
	sleep(1);
};

if ($res)
{
	print " ok\n";
	exit(0);
};

print " failed\n";
exit(1);
