<?php
require_once 'db-connect.php';

$result = $conn->query("SELECT * FROM tasks");

$tasks = [];

while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

echo json_encode($tasks);

$conn->close();
?>
