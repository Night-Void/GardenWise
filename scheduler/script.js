$(document).ready(function() {
    let taskList = [];

    // Fetch tasks from the server
    $.getJSON('get_tasks.php', function(data) {
        taskList = data;
        displayTasks(taskList);
    });

    // Display tasks in the task list section
    function displayTasks(tasks) {
        let taskListHtml = '<h4>Scheduled Tasks</h4><ul class="list-group">';
        tasks.forEach(function(task) {
            taskListHtml += `
                <li class="list-group-item">
                    <strong>${task.task_name}</strong> - ${task.reminder_date} ${task.reminder_time}
                    <a href="delete_task.php?id=${task.id}" class="btn btn-danger btn-sm float-end">Delete</a>
                </li>`;
        });
        taskListHtml += '</ul>';
        $('#taskList').html(taskListHtml);
    }

    // Function to check reminders
    function checkReminders() {
        const now = new Date();
        const currentDate = now.toISOString().split('T')[0];
        const currentTime = now.toTimeString().split(' ')[0].substring(0, 5);

        taskList.forEach(function(task, index) {
            if (task.reminder_date === currentDate && task.reminder_time === currentTime) {
                showReminder(task.task_name);
                taskList.splice(index, 1);  // Remove the task once reminder is shown
            }
        });
    }

    // Show reminder in bell icon
    function showReminder(taskName) {
        $('#reminderMessage').text(taskName);
        $('#reminderAlert').fadeIn();
        setTimeout(function() {
            $('#reminderAlert').fadeOut();
        }, 5000); // Auto-hide after 5 seconds
    }

    // Check for reminders every minute
    setInterval(checkReminders, 60000); // 60 seconds
});
