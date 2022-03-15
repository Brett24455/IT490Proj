#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
    // connect to DB
    $db = 'localhost';
    $user = 'webClient';
    $pass = 'GrAtMaPaLeGo';

    $conn = new mysqli($db, $user, $pass);

    if($conn->connection_error){
        die("Connection failed: ". $conn->connection_error);
    }
    else{
        echo "Connected successfully.";
    }

    // lookup username in database
    $s = " select * from USERS where username='$username' ";
    ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
    $count = mysqli_num_rows($t);
    echo "<br>Count: $count";
    if($count == 0) {
        echo "<br>Invalid Username."; 
	return false;
    };

    // check password
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    $hash = $r['hash'];
    if(password_verify($password, $hash)){
	echo "<br>Valid Password";
    } else {
	echo "<br>Invalid Password";
    }
    return password_verify($password, $hash);
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

