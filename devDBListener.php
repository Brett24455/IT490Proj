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
    $db = 'devwebdb';

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
    $hash = $r['password'];
    if(password_verify($password,$hash)){
	echo PHP_EOL."Valid Password".PHP_EOL;
    } else {
	echo PHP_EOL."Invalid Password".PHP_EOL;
    }

    return (password_verify($password,$hash));
}

function doRegister($username,$password)
{
    // connect to DB
    $host = 'localhost';
    $user = 'webClient';
    $pass = 'GrAtMaPaLeGo';
    $db = 'devwebdb';

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
    $db = 'devwebdb';

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
    $db = 'devwebdb';

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
    $playerRank = $r['ranking'];
    if($playerRank == 0){
	    $w = "UPDATE USERS SET wins = wins+1 WHERE username='$username'";
	    ($t = mysqli_query($conn, $w)) or die(mysqli_error($conn));
	    //I did this in a weird way, my brain is slightly fried but it works
	    $max = "SELECT MAX(ranking) AS 'max' FROM USERS";
	    ($t = mysqli_query($conn, $max)) or die(mysqli_error($conn));
	    $max = mysqli_fetch_array($t, MYSQLI_ASSOC); 
	    $m = $max['max']+1;
	    //if($m == 0) {$m = 1;} 

	    $r = "UPDATE USERS SET ranking = '$m' WHERE username='$username'";
	    ($t = mysqli_query($conn, $r)) or die(mysqli_error($conn));
    }
    //if the player is the highest rank, just update wins
    else if($playerRank == 1){
	    //Check to see if any other players are in 1st, lower everyone elses rank if so
	    $uw = $r['wins'];
	    $dupe = "SELECT count(*) AS 'count' FROM USERS where wins = '$uw'";
            ($t = mysqli_query($conn, $dupe)) or die(mysqli_error($conn));
	    $dupe = mysqli_fetch_array($t, MYSQLI_ASSOC);
	    if($dupe['count'] > 0){
		$l = "UPDATE USERS SET ranking = ranking+1 WHERE username!='$username' AND ranking>0";
                ($t = mysqli_query($conn, $l)) or die(mysqli_error($conn));
	    }
	    $w = "UPDATE USERS SET wins = wins+1 WHERE username='$username'";
            ($t = mysqli_query($conn, $w)) or die(mysqli_error($conn));
    }else{
	    $uw = $r['wins']; //User wins
	    //Find out if there are any players with the same amount of wins
	    $dupe = "SELECT count(*) AS 'count' FROM USERS where wins = '$uw'";
	    ($t = mysqli_query($conn, $dupe)) or die(mysqli_error($conn));
	    $dupe = mysqli_fetch_array($t, MYSQLI_ASSOC); 

	    //Find the amount of wins the player in the next rank has
	    $nextuser = "SELECT * FROM USERS WHERE ranking = ('$playerRank'+1)";
	    ($t = mysqli_query($conn, $nextuser)) or die(mysqli_error($conn));
	    $nrw = mysqli_fetch_array($t, MYSQLI_ASSOC); 
	    if($nrw != null){ $nrw = $nrw['wins']; }

	    //If there are duplicate users with the same wins and rank, update the player rank
	    if($dupe['count'] > 0){
		$w = "UPDATE USERS SET wins = wins+1, ranking = ranking-1  WHERE username='$username'";
		($t = mysqli_query($conn, $w)) or die(mysqli_error($conn));
	    //Dont update any rank if the user wont rank up
    	    }else if(($uw+1) < $nrw){
	    	$w = "UPDATE USERS SET wins = wins+1 WHERE username='$username'";
		($t = mysqli_query($conn, $w)) or die(mysqli_error($conn));
	    //Update the rank of the player to the same rank if they have as many wins as the next rank
	    }else if(($uw+1) == $nrw){
		    $w = "UPDATE USERS SET wins = wins+1, ranking = ranking-1  WHERE username='$username'";
		    ($t = mysqli_query($conn, $w)) or die(mysqli_error($conn));
	    //Update the players rank, and lower all players in the next rank down if the player has more wins than them
	    }else{
		    $w = "UPDATE USERS SET wins = wins+1, ranking = ranking-1  WHERE username='$username'";
		    $l = "UPDATE USERS SET ranking = ranking+1 WHERE wins='$nrw'";
		    ($t = mysqli_query($conn, $l)) or die(mysqli_error($conn));
		    ($t = mysqli_query($conn, $w)) or die(mysqli_error($conn));
	    }
    }
    //fetch updated row
    ($t = mysqli_query($conn, $s)) or die(mysqli_error($conn));
    $u = mysqli_fetch_array($t, MYSQLI_ASSOC);

    return "You won your match! You have ".$u['wins']." win(s).".PHP_EOL."You are rank ".$u['ranking']." on the leaderboards.";

}

function addCardIntoDeck($username, $deckno, $card)
{
    // connect to DB
    $host = 'localhost';
    $user = 'webClient';
    $pass = 'GrAtMaPaLeGo';
    $db = 'devwebdb';

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
    $r = mysqli_fetch_array($t, MYSQLI_ASSOC);

    //Look up the specific Deck the user is trying to add to. If it is null, create the deck in the DECKS table, and insert
    //the deck ID into the USERS table
    //If the specific deck does have an ID, take it and look for it in the DECKS table
    switch($deckno){
    case "1":
	    $deckid = $username."1";
	    if($r['deck1ID'] == null){
		//$i = " insert into DECKS (deckId) values('$deckid') ";
		//($t = mysqli_query($conn, $i)) or die(mysqli_error($conn));
	        echo "BABABOOEY".$username;
		$i = " UPDATE USERS SET deck1ID='$deckid' WHERE username='$username' ";
		($t = mysqli_query($conn, $i)) or die(mysqli_error($conn));
		echo "H<br><br>";
		$i = " insert into DECKS (deckId) values('$deckid') ";
                ($t = mysqli_query($conn, $i)) or die(mysqli_error($conn));

	    }
	    break;
            //$s = " select * from DECKS where deckId = '$deckid'";
            //($t = mysqli_query($conn, $s)) or die(mysqli_error($conn));
	    //$deckrow = mysqli_fetch_array($t, MYSQLI_ASSOC);
            
    case "2":
	$deckid = $username."2";
            if($r['deck2ID'] == null){
                $i = " insert into DECKS (deckId) values('$deckid') ";
                ($t = mysqli_query($conn, $i)) or die(mysqli_error($conn));
                $i = " UPDATE USERS SET deck2ID='$deckid' WHERE username='$username' ";
                ($t = mysqli_query($conn, $i)) or die(mysqli_error($conn));
	    }
	break;
            
    case "3":
	$deckid = $username."3";
            if($r['deck3ID'] == null){
                $i = " insert into DECKS (deckId) values('$deckid') ";
                ($t = mysqli_query($conn, $i)) or die(mysqli_error($conn));
                $i = " UPDATE USERS SET deck1ID='$deckid' WHERE username='$username' ";
                ($t = mysqli_query($conn, $i)) or die(mysqli_error($conn));
	    }
	break;
	    
    }
    //check through the table to see if any of the card JSON objects have the type of null. If so, insert the JSON file there
    echo "<br>HELLO THERE<br>";
    $s = " select * from DECKS where deckId = '$deckid' ";
    ($t = mysqli_query($conn, $s)) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($t, MYSQLI_ASSOC);

    for($no = 1; $no <= 10; $no++){
	$cardno = "card".$no;
	//$s = " select '$cardno' from DECKS where deckId = '$deckid' ";
	//($t = mysqli_query($conn, $s)) or die(mysqli_error($conn));
	//$currCard = mysqli_fetch_array($t, MYSQLI_ASSOC);
	if(is_null($row[$cardno])){
		$i = " UPDATE DECKS SET $cardno='$card' WHERE deckId='$deckid' ";
		($t = mysqli_query($conn, $i)) or die(mysqli_error($conn));
		echo "Card inserted into deck ".$deckid;
		return true;
	}
    }
   
    //If all card columns are full, return a string to the user telling them to delete a card before they can add another one
    echo "Deck is full. Please delete a card from your deck.";
    return false;
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
    case "deck":
	    $card = array();
	    $card['name'] = $request['name'];
	    $card['level'] = $request['level'];
	    $card['atk'] = $request['atk'];
	    $card['def'] = $request['def'];
	    $card['desc'] = $request['desc'];
	    $card = json_encode($card);
	    return addCardIntoDeck($request['username'], $request['deckno'], $card);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("devDBRabbitMQ.ini","dbListener");

$server->process_requests('requestProcessor');
exit();
?>

