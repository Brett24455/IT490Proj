<?php
<<<<<<< HEAD

session_start();

session_unset();

session_destroy();

header('location:main_page.php');

?>

=======
include("config.php");
session_destroy();
echo "Logged out.";
header("refresh: 3; url=login.html");
?>
>>>>>>> 90b124d9b7eb5173636b7905e6282757c71e9a21
