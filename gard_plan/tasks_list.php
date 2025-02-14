<?php
include 'db_connect.php';

// Fetch tasks from the database
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Task List</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Task ID</th>
                    <th>Task Name</th>
                    <th>Task Description</th>
                    <th>Task Date</th>
                    <th>Reminder Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['task_id'] . "</td>";
                        echo "<td>" . $row['task_name'] . "</td>";
                        echo "<td>" . $row['task_description'] . "</td>";
                        echo "<td>" . $row['task_date'] . "</td>";
                        echo "<td>" . $row['reminder_time'] . "</td>";
                        echo "<td>
                                <form action='update_task_form.php' method='get' style='display:inline;'>
                                    <input type='hidden' name='task_id' value='" . $row['task_id'] . "'>
                                    <button type='submit' class='btn btn-primary'>Update</button>
                                </form>
                                <form action='delete_task.php' method='post' style='display:inline;'>
                                    <input type='hidden' name='task_id' value='" . $row['task_id'] . "'>
                                    <button type='submit' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this task?');\">Delete</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No tasks found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>
