<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

include("config.php");
if(!isset($_SESSION["logged"])){
        echo "Please Log in.";
        header( "refresh: 3; url=login.html" );
        exit();
}

$client = new rabbitMQClient("dmzWebsiteRabbitMQ.ini","testServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$msg = $_GET['search'];

$request = array();
$request['type'] = "search";
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]." END".PHP_EOL;



?>
