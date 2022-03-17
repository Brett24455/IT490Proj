<?php

session_start();

#connect to db
require_once('webdb');

$user_name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$conf_password = $_POST["confpassword"];

#checks for any empty fields
function empty_fields($user_name, $email, $password, $conf_password) {
    if(empty($user_name) || ($email) || ($password) || ($conf_password)) {
        $val;
        $val = true;
    }
    else {
        $val;
        $val = false;
    }
    return $val;
}

#checks to see if username is taken 
function invalid_username($password, $conf_password) {
    
}

#checks if email format is correct and if email is taken
function invalid_email($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $val;
        $val = true;
    }
    else {
        $val;
        $val = false;
    }
    return $val;
}

#checks to see the passwords match
function invalid_pass($password, $conf_password) {
    if($password !== $conf_password) {
    $val;
    $val = true;
}
else {
        $val;
        $val = false;
    }
    return $val;
}



if (empty_fields() === true) {
    #didnt fillout the form
    exit();
}

if (invalid_username() === true) {
    #username already taken
    exit();
}

if (invalid_email() === true) {
    #email already in use
    exit();
}

if (invalid_pass() === true) {
    #passwords dont match
    exit();
}

register_user($conn, $user_name, $email, $password);
