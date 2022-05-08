<?php
include("config.php");
session_destroy();
echo "Logged out.";
header("refresh: 3; url=login.html");
?>
