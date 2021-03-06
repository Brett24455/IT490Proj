<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include('config.php');

function sanitize($field){
        $field = trim($field);
        return $field;
}


function login($username, $password){

	$client = new rabbitMQClient("dbWebsiteRabbitMQ.ini","testServer");
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

$user = $_GET["username"]; $pass = $_GET["password"];
$user = sanitize($user); $pass = sanitize($pass);


if(login($user, $pass)){
	echo "<br>Logged In. Redirecting.";
	$_SESSION["logged"] = true;
	$_SESSION["user"] = $user;
	header( "refresh: 3; url=homepage.php" );
	exit();
}
else{
	echo "<br>Failed login.";
	header( "refresh: 3; url=login.html" );
	exit();
}
?>
