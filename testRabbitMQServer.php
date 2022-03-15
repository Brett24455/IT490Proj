#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
    $client = new rabbitMQClient("dbRabbitMQ.ini", "dbListener");
    if (isset($argv[1]))
    {
      $msg = $argv[1];
    }
    else
    {
      $msg = "test message";
    } 

    $request = array();
    $request['type'] = "login";
    $request['username'] = $username;
    $request['password'] = $password;
    $response = $client->send_request($request);
    //$response = $client->publish($request);

    echo "client received response: ".PHP_EOL;
    print_r($response);
    echo "\n\n";

    return $response;
    //return true;
    //return false if not valid
}

function doSearch($message)
{
    $client = new rabbitMQClient("dmzRabbitMQ.ini", "dmzListener");
    if (isset($argv[1]))
    {
      $msg = $argv[1];
    }
    else
    {
      $msg = "test message";
    }

    $request = array();
    $request['type'] = "search";
    $request['message'] = $message;
    $response = $client->send_request($request);
    //$response = $client->publish($request);

    echo "client received response: ".PHP_EOL;
    print_r($response);
    echo "\n\n";

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
    case "login":
      return doLogin($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
    case "search":
      return doSearch($request['message']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>
