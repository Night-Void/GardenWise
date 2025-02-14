<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'login_register_db';
$conn = new mysqli($server, $username, $password, $database, 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
