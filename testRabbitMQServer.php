#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

/*
 * Any work done to this file was a mistake on my part,
 * please ignore it and look to the files dbListener and
 * dmzListener for the actual server files that process requests
 */


function sanitize($field){
	//$temp = $_GET[$field];
	$temp = trim($field);
	return $temp;
}

function doLogin($username,$password)
{ 
    /*$client = new rabbitMQClient("dbRabbitMQ.ini", "dbListener");

    $request = array();
    $request['type'] = "login";
    $request['username'] = $username;
    $request['password'] = $password;
    echo "Sending request".PHP_EOL;
    $response = $client->send_request($request);
    //$response = $client->publish($request);

    echo "client received response: ".PHP_EOL;
    print_r($response);
    echo "\n\n";
    
    if($response){
	    return true;
    }*/
    return false;
    //return true;
    //return false if not valid
}

function doSearch($message)
{
    /*$client = new rabbitMQClient("dmzRabbitMQ.ini", "dmzListener");
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
    */
    return false;

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
      $u = sanitize($request['username']); $p = sanitize($request['password']);
      return doLogin($u, $p);
    case "validate_session":
      return doValidate($request['sessionId']);
    case "search":
      $m = sanitize($request['message']);
      return doSearch($m);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>
