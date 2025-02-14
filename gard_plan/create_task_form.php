<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Create Task</h1>
        <form action="create_task.php" method="post">
            <div class="form-group">
                <label for="task_name">Task Name:</label>
                <input type="text" id="task_name" name="task_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="task_description">Task Description:</label>
                <textarea id="task_description" name="task_description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="task_date">Task Date:</label>
                <input type="date" id="task_date" name="task_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="reminder_time">Reminder Time:</label>
                <input type="time" id="reminder_time" name="reminder_time" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Task</button>
        </form>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
