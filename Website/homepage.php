<?php
include("config.php");
if(!isset($_SESSION["logged"])){
	echo "Please Log in.";
	header( "refresh: 3; url=login.html" );
	exit();
}
?>

<!DOCTYPE html>
<meta charset="UTF-8">

<style>
        #F1 {border: 3px solid blue; width: 50%; margin: auto; margin-top: 80px}
</style>

<form action = "search.php" id="F1">

        <input type="text" name="search">Search for cards<br>

        <button type="submit" name="submit">Search</button>
</form>

<a href = "matchmaking.php"><br>Play a match</a>
<a href = "deckbuilding.php"><br>Create a deck</a>

