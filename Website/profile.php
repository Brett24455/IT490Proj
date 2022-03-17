<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include('config.php');


function getProfile($username){

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
        $request['type'] = "profile";
        $request['username'] = $username;
        $response = $client->send_request($request);
        //$response = $client->publish($request);

        return $response;
}

$user = $_SESSION["user"];
$profile = getProfile($user);

echo "Username: ".$user;
if($profile['rank'] == null){ echo "<br>Rank: N/A"; }
else { echo "<br>Rank: ".$profile['rank']; };
echo "<br>Wins: ".$profile['wins'];

?>

<!DOCTYPE html>
<a href = "homepage.php"><br>Home Page</a>
