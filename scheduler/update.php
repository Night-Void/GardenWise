<?php
// Include the database connection
require_once 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['task_name'])) {
        $id = $_POST['id'];
        $task_name = trim($_POST['task_name']);

        // Prepare the SQL statement for updating the task name
        $sql = "UPDATE reminders SET task_name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("si", $task_name, $id);

            if ($stmt->execute()) {
                // Redirect to index.php with success message
                header("Location: index.php?message=Task updated successfully!");
            } else {
                // Log error and redirect with error message
                error_log("Error updating task: " . $stmt->error);
                header("Location: index.php?error=Error updating task.");
            }
            $stmt->close();
        } else {
            // Log error if preparation fails
            error_log("Prepare statement failed: " . $conn->error);
            header("Location: index.php?error=Database error.");
        }

        $conn->close();
        exit();
    }
}
?>
