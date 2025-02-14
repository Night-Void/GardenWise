<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $task_id = $_GET['task_id'];

    $sql = "DELETE FROM tasks WHERE task_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    if ($stmt->execute()) {
        header("Location: tasks_list.php"); // Redirect to task list after deletion
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
