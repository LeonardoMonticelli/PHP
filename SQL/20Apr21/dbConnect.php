<?php
session_start();
if(!isset($_SESSION["isUserLoggedIn"])){
    $_SESSION["isUserLoggedIn"] = false;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "wsers2";

$connection = mysqli_connect($servername, $username, $password, $dbName);

if (!$connection){
    die("Connection failed: " . mysqli_connect_error());
}
?>