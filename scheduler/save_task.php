<?php
// Include the database connection
require_once 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Combine date and time into a single datetime format
    $reminder_datetime = $date . ' ' . $time;

    // Insert task into the database
    $sql = "INSERT INTO reminders (task_name, description, reminder_datetime) VALUES ('$task_name', '$description', '$reminder_datetime')";
    if ($conn->query($sql)) {
        echo "<script>alert('Task Scheduled Successfully!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error scheduling task.'); window.location.href = 'index.php';</script>";
    }

    $conn->close();
}
?>
