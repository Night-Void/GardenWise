<?php
include 'db_connect.php';

$current_date = date('Y-m-d');
$sql = "SELECT R.reminder_id, T.task_name, T.task_date 
        FROM reminders R 
        JOIN tasks T ON R.task_id = T.task_id 
        WHERE R.reminder_date = ? AND R.reminder_sent = FALSE";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $current_date);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    // Send reminder (e.g., email, notification)
    echo "Reminder: Task '" . $row['task_name'] . "' is due on " . $row['task_date'] . "<br>";

    // Mark reminder as sent
    $sql_update = "UPDATE reminders SET reminder_sent = TRUE WHERE reminder_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $row['reminder_id']);
    $stmt_update->execute();
}

$stmt->close();
$conn->close();
?>
