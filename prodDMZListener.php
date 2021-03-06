#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doSearch($msg)
{
	
    // lookup $msg/card in the api
	$data = file_get_contents("https://db.ygoprodeck.com/api/v7/cardinfo.php?name=".$msg);
	$response_data = json_decode($data, true);
	//var_dump($response_data['data'][0]['name']);
	// return all necessary data back
    $response = array();
    $response['name'] = $response_data['data'][0]['name'];
    $response['rating'] = $response_data['data'][0]['level'];
    $response['atk'] = $response_data['data'][0]['atk'];
    $response['def'] = $response_data['data'][0]['def'];
    $response['effect'] = $response_data['data'][0]['desc'];

    // return $response;
    return $response;
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

$server = new rabbitMQServer("prodDMZRabbitMQ.ini","dmzListener");

$server->process_requests('requestProcessor');
exit();
?>

