<?php
        require_once('path.inc');
	require_once('get_host_info.inc');
        require_once('rabbitMQLib.inc');
        include('config.php');

	if(!isset($_SESSION["logged"])){
        echo "Please Log in.";
        header( "refresh: 3; url=login.html" );
        exit();
	}

function win(){
        $client = new rabbitMQClient("dbWebsiteRabbitMQ.ini","testServer");
        if (isset($argv[1]))
        {
          $msg = $argv[1];
        }
        else
        {
          $msg = "test message";
        }

        $username = $_SESSION['user'];
        $request = array();
        $request['type'] = "ranking";
        $request['username'] = $username;
        $response = $client->send_request($request);

        echo "client received response: ".PHP_EOL;
        print_r($response);

        echo $argv[0]." END".PHP_EOL;
}


win();

?>

