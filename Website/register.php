bababooey
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function sanitize($field){
        $field = trim($field);
        return $field;
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

	//Hash the password given
	$password = password_hash($password, PASSWORD_BCRYPT);
	echo $password.": The Hash.";

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
	echo "Failed to create account.";
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

