#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doSearch($msg)
{
	
    // lookup $msg/card in the api

    // return all necessary data back
    /*	
    $response = array();
    $response['name'] = ;
    $response['rating'] = ;
    $response['atk'] = ;
    $response['def'] = ;
    $response['effect'] = ;
    */

    // return $response;
    return "Unfinished function ".$msg;
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "search":
      return doSearch($request['message']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("dmzRabbitMQ.ini","dmzListener");

$server->process_requests('requestProcessor');
exit();
?>

