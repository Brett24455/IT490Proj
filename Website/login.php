#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function login($username, $password){

	$client = new rabbitMQClient("testWebsiteRabbitMQ.ini","testServer");
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

	echo $argv[0]." END".PHP_EOL;


	if(!$response){ 
		return false; 
	}
	return true;
}

$user = $_GET["username"];
$pass = $_GET["password"];

if(login($user, $pass)){
	header('location:homepage.html error=logged in');
	echo "<br>Logged In.";
}
else{
	header('location:gameindex.html error=login failed');
	echo "<br>Failed login.";
	exit();
}
?>
