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

//echo "client received response: ".PHP_EOL;
print_r("Name: ".$response['name']);
echo "\n";
print_r("Level: ".$response['rating']);
echo " ".PHP_EOL;
print_r("Attack: ".$response['atk']);
echo " ".PHP_EOL;
print_r("Defense: ".$response['def']);
echo " ".PHP_EOL;
print_r("Description: ".$response['effect']);
echo " ".PHP_EOL;

$html_input = implode(",", $response);

?>
<!DOCTYPE html>

<style>
        #F1 {border: 3px solid blue; width: 50%; margin: auto; margin-top: 80px}
</style>

<form action = "addDeck1.php" id="F1">
	<button type="submit" name="submit" value="<?php echo $html_input ?>">Add to Deck 1</button>
</form>
<form action = "addDeck2.php" id="F1">
        <button type="submit" name="submit" value="<?php echo $html_input ?>">Add to Deck 2</button>
</form>
<form action = "addDeck3.php" id="F1">
        <button type="submit" name="submit" value="<?php echo $html_input ?>">Add to Deck 3</button>
</form>
