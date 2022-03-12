<?php
$db = 'localhost';
$user = 'webClient';
$pass = 'GrAtMaPaLeGo';

$conn = new mysqli($db, $user, $pass);

if($conn->connection_error){
	die("Connection failed: ". $conn->connection_error);
}
else{
	echo "Connected successfully.";
}

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

?>
