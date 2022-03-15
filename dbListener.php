#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
    // connect to DB
    $host = 'localhost';
    $user = 'webClient';
    $pass = 'GrAtMaPaLeGo';
    $db = 'webdb';

    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    ini_set('display_errors', 1);
    $conn = new mysqli($host, $user, $pass);
    if($conn->connect_error){
	    die("Connection failed: ".mysqli_connect_error());
    }
    echo "Connected successfully.";
    mysqli_select_db($conn, $db);

    // lookup username in database
    $s = " select * from USERS where username='$username' ";
    ($t = mysqli_query($conn, $s)) or die(mysqli_error($conn));
    $count = mysqli_num_rows($t);
    echo "<br>Count: $count";
    if($count == 0) {
        echo "<br>Invalid Username."; 
	return false;
    };

    // check password
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    $matchpass = $r['password'];
    if($password == $matchpass){
	echo "<br>Valid Password";
    } else {
	echo "<br>Invalid Password";
    }
    return ($password == $matchpass);
    //return "Whats good ".$username;
    //return false if not valid
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
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("dbRabbitMQ.ini","dbListener");

$server->process_requests('requestProcessor');
exit();
?>

