<?php
function authenticate ($username, $password, $db){
	$s = " select * from users where username='$username' ";
	($t = mysqli_query($db, $s) or die(mysqli_error($db));
	$count = mysqli_num_rows($t);
	if($count == 0) { echo "<br>Invalid username"; return false; };

	$r = mysqli_fetch_array($t, MYSQLI_ASSOC);
	$hash = $r[ 'hash' ];
	if(password_verify($password, $hash)){
		echo '<br>Logged in';
	} else {
		echo '<br>Incorrect password';
	}
	return password_verify($password, $hash);
}
?>
