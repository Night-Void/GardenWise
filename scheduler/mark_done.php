<?php
// Include the database connection
require_once 'db-connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Update the reminder as completed in the database
    $sql = "UPDATE reminders SET is_completed = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Task marked as done successfully!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error marking task as done.'); window.location.href = 'index.php';</script>";
    }

    $stmt->close();
}
$conn->close();
?>