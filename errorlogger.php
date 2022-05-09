#!/usr/bin/php
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

error_reporting(E_ALL);
ini_set("display_errors", "On");
ini_set("ignore_repeated_errors", "TRUE");
ini_set("log_errors", "On");
ini_set("error_log", "~/git/IT490Proj/errorlogging.txt");

$filename = file_get_contents("errorlogging.txt");

$rabbitmqclient = new rabbitMQClient("eventlogger.ini", "testServer");

$funcVal = logProcessor($request);

function logProcessor($error)
{
	$client = new rabbitMQClient("log.ini", "testServer");
	echo 'message sent';

	$response = $client->publish($error);

	return $response;
}

file_put_contents("~/git/IT490Proj/errorlogging.txt", $funcVal, FILE_APPEND);
logProcessor("test error");
?>








