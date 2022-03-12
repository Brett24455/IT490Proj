<?php
function login($username, $password){
	if($username != "testUser"){
		echo "Invalid Username"; 
		return false; 
	}

	if($password == "testPassword"){
		echo "Correct Username and Password.";
	}else{
		echo "Incorrect password"; 
		return false;
	}
	return true;
}

$user = $_GET["username"];
$pass = $_GET["password"];

if(!login($user, $pass)){
	echo "<br>Failed login.";
}
else{
	echo "<br>Logged in.";
}

if (!$conn->query('CREATE DATABASE players)){
	printf()
}

$conn->query('CREATE TABLE 'players')
(
	'username' VARCHAR(22)  NOT NULL,
	'password' VARCHAR(22) NOT NULL,
	'deck1ID' INT,
	'deck2ID' INT,
	'deck3ID' INT,
	'wins' INT,
	'RANKING' INT,	
PRIMARY KEY ('username')
FOREIGN KEY (deckID) REFERENCES 

);

?>
