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
	echo PHP_EOL."Valid Password".PHP_EOL;
    } else {
	echo PHP_EOL."Invalid Password".PHP_EOL;
    }

    return ($password == $matchpass);
}

function doRegister($username,$password)
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
    if($count >= 1) {
        echo "<br>Username is already taken.";
        return "taken";
    };
    
    // Insert username and password into DB
    $i = " insert into USERS (username, password) values('$username', '$password') ";
    ($t = mysqli_query($conn, $i)) or die(mysqli_error($conn));
    return "inserted";
}

function getProfile($username)
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
    
    // get whole user row and return specific ranking into an array
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    $info = array();
    $info['rank'] = $r['ranking'];
    $info['wins'] = $r['wins'];

    return $info;
}

function updateRank($username){
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

    // get whole user row
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
    //Update the user's value to the lowest possible rank if they won their first match
    if($r['ranking'] == 0){
	    $w = "UPDATE USERS SET wins = wins+1 WHERE username='$username'";
	    ($t = mysqli_query($conn, $w)) or die(mysqli_error($conn));
	    //I did this in a weird way, my brain is slightly fried but it works
	    $max = "SELECT MAX(ranking) AS 'max' FROM USERS";
	    ($t = mysqli_query($conn, $max)) or die(mysqli_error($conn));
	    $max = mysqli_fetch_array($t, MYSQLI_ASSOC); 
	    $m = $max['max']+1; 

	    $r = "UPDATE USERS SET ranking = '$m' WHERE username='$username'";
	    ($t = mysqli_query($conn, $r)) or die(mysqli_error($conn));
    }
    else{
	    $w = "UPDATE USERS SET wins = wins+1 WHERE username='$username'";
	    ($t = mysqli_query($conn, $w)) or die(mysqli_error($conn));
    }
    //fetch updated row
    ($t = mysqli_query($conn, $s)) or die(mysqli_error($conn));
    $u = mysqli_fetch_array($t, MYSQLI_ASSOC);

    return "You won your match! You have ".$u['wins']." win(s).".PHP_EOL."You are rank ".$u['ranking']." on the leaderboards.";

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
    case "register":
	    return doRegister($request['username'],$request['password']);
    case "profile":
	    return getProfile($request['username']);
    case "ranking":
	    return updateRank($request['username']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("dbRabbitMQ.ini","dbListener");

$server->process_requests('requestProcessor');
exit();
?>

