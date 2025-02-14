<?php

$servername = "localhost";
$username = "root";
$password = ""; // Use an empty string if there's no password
$database = "gardenwise";
$port = 3307; // Replace with your MySQL port if it's different

$conn = mysqli_connect($servername, $username, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
