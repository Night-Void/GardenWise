<?php
include 'db_connect.php';

// Fetch task details
$task_id = $_GET['task_id'];
$sql = "SELECT * FROM tasks WHERE task_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Update Task</h1>
        <form action="update_task.php" method="post">
            <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
            
            <div class="form-group">
                <label for="task_name">Task Name:</label>
                <input type="text" id="task_name" name="task_name" class="form-control" value="<?php echo $task['task_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="task_description">Task Description:</label>
                <textarea id="task_description" name="task_description" class="form-control"><?php echo $task['task_description']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="task_date">Task Date:</label>
                <input type="date" id="task_date" name="task_date" class="form-control" value="<?php echo $task['task_date']; ?>" required>
            </div>

            <div class="form-group">
                <label for="reminder_time">Reminder Time:</label>
                <input type="time" id="reminder_time" name="reminder_time" class="form-control" value="<?php echo $task['reminder_time']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Task</button>
        </form>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
