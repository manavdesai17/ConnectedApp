<?php

// Database credentials
$host="localhost";
$user="root";
$pass="";
$database="test";

$con = mysqli_connect("$host", "$user", "$pass", "$database");

// Stop session if database does not connect
if ($con === false){
    die("Connot Connect to Database.");
    session_destroy();
}

?>