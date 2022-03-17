bababooey
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

<<<<<<< HEAD
session_start();

#connect to db
require_once('webdb');

$user_name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$conf_password = $_POST["confpassword"];

#checks for any empty fields
function empty_fields($user_name, $email, $password, $conf_password) {
    if(empty($user_name) || ($email) || ($password) || ($conf_password)) {
        $val;
        $val = true;
    }
    else {
        $val;
        $val = false;
    }
    return $val;
=======
function sanitize($field){
        $field = trim($field);
        return $field;
>>>>>>> 90b124d9b7eb5173636b7905e6282757c71e9a21
}


function register($username, $password){

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
        $request['type'] = "register";
        $request['username'] = $username;
        $request['password'] = $password;
        $response = $client->send_request($request);
        //$response = $client->publish($request);

        echo "client received response: ".PHP_EOL;
        print_r($response);
        echo "\n\n";

        echo $argv[0]." END".PHP_EOL;

	switch($response)
	{
		case "taken":
			echo "Username has already been taken";
			return false;
		case "inserted":
			echo "Account successfully created! Redirecting to login.";
			return true;
        }
        return false;
}

$user = $_GET["username"]; $pass = $_GET["password"]; $cpass = $_GET["cpassword"];
$user = sanitize($user); $pass = sanitize($pass); $cpass = sanitize($cpass);

if($pass != $cpass){
	echo "<br>Passwords do not match";
	header( "refresh: 3; url=register.html" );
}

if(register($user, $pass)){
        //echo "<br>Created an account. Redirecting to login page.";
        header( "refresh: 3; url=login.html" );
        exit();
}
else{
        echo "<br>Failed to register.";
        header( "refresh: 3; url=register.html" );
        exit();
}
?>

