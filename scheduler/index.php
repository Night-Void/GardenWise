<?php
// Include the database connection file
require_once 'db-connect.php';

date_default_timezone_set('Asia/Kolkata');

// Fetch scheduled tasks from the database
$query = "SELECT * FROM reminders";
$result = $conn->query($query);

// Fetch current datetime
$current_time = date('Y-m-d H:i:s');

// Array to hold due reminders
$due_reminders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check if the reminder time is due and not completed
        if ($current_time >= $row['reminder_datetime'] && !$row['is_completed']) {
            $due_reminders[] = $row;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GardenWise Task Scheduler</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">GardenWise Task Scheduler</a>
    <div class="ml-auto">
        <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="bellDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <!-- Replaced Font Awesome bell icon with SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                  <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
                </svg>
                <span class="badge badge-danger" id="reminder-count"><?= count($due_reminders) ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bellDropdown">
                <?php if (count($due_reminders) > 0): ?>
                    <?php foreach ($due_reminders as $reminder): ?>
                        <a class="dropdown-item" href="#"><?= 'Reminder: ' . htmlspecialchars($reminder['task_name']) ?></a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <a class="dropdown-item" href="#">No new reminders</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Task Scheduling Form -->
<div class="container mt-4">
    <h3>Schedule Your Task</h3>
    <form action="save_task.php" method="POST">
        <div class="form-group">
            <label for="task_name">Task Name</label>
            <input type="text" class="form-control" id="task_name" name="task_name" required>
        </div>
        <div class="form-group">
            <label for="description">Task Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="form-group">
            <label for="date">Date of Reminder</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="time">Time of Reminder</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>
        <button type="submit" class="btn btn-primary">Schedule Task</button>
    </form>
    
    <h4 class="mt-5">Scheduled Tasks</h4>

<!--<ul class="list-group">
        <?php
        // Re-establish database connection to fetch tasks
        $conn = new mysqli("localhost", "root", "", "scheduler", 3307);
        $query = "SELECT * FROM reminders";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li class='list-group-item'>" . htmlspecialchars($row['task_name']) . " - " . htmlspecialchars($row['reminder_datetime']) . 
                //" <a href='mark_done.php?id=" . $row['id'] . "' class='btn btn-success btn-sm float-right ml-2'>Mark as Done</a>" . 
                " <a href='delete_task.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm float-right'>Delete</a></li>";
            }
        } else {
            echo "<li class='list-group-item'>No tasks scheduled</li>";
        }
        ?>
    </ul>
</div> -->
    
<ul class="list-group">
    <?php
    // Re-establish database connection to fetch tasks
    $conn = new mysqli("localhost", "root", "", "scheduler", 3307);
    $query = "SELECT * FROM reminders";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<li class='list-group-item'>";
            echo "<span>" . htmlspecialchars($row['task_name']) . " - " . htmlspecialchars($row['reminder_datetime']) . "</span>";
            echo "<div class='float-right d-flex' style='gap: 10px;'>"; // Flexbox for spacing
            echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#updateModal" . $row['id'] . "'>Update</button>";
            echo "<button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#deleteModal" . $row['id'] . "'>Delete</button>";
            echo "</div>";
            echo "</li>";

            // Modal for updating task name
            echo "
            <div class='modal fade' id='updateModal" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='updateModalLabel" . $row['id'] . "' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='updateModalLabel" . $row['id'] . "'>Update Task Name</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <form action='update.php' method='POST'>
                            <div class='modal-body'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                                <div class='form-group'>
                                    <label for='task_name'>Task Name</label>
                                    <input type='text' class='form-control' id='task_name' name='task_name' value='" . htmlspecialchars($row['task_name']) . "' required>
                                </div>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                <button type='submit' class='btn btn-primary'>Update Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            ";

            // Modal for deleting task confirmation
            echo "
            <div class='modal fade' id='deleteModal" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel" . $row['id'] . "' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='deleteModalLabel" . $row['id'] . "'>Confirm Deletion</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            Are you sure you want to delete this task?
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                            <a href='delete_task.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            ";
        }
    } else {
        echo "<li class='list-group-item'>No tasks scheduled</li>";
    }
    ?>
</ul>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Font Awesome for Bell Icon -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<i class="fas fa-bell"></i>


</body>
</html>