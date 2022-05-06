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

function sanitize($field){
        $field = trim($field);
        return $field;
}


function addToDeck2($username, $card){

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
	$request['type'] = "deck";
	$request['username'] = $username;
	$request['deckno'] = "2";
	$request['name'] = $card[0];
	$request['level'] = $card[1];
	$request['atk'] = $card[2];
	$request['def'] = $card[3];
	$request['desc'] = $card[4];
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

$card = $_GET["submit"]; $user = $_SESSION["user"];
$card = explode(",", $card);

if(addToDeck2($user, $card)){
        echo "<br>Card added to deck. Redirecting.";
        header( "refresh: 3; url=homepage.php" );
        exit();
}
else{
        echo "<br>Failed to add card.";
        header( "refresh: 3; url=homepage.php" );
        exit();
}
?>

