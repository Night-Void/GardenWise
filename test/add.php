<?php
include_once('connection.php');

if(isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Form validation
    if(empty($name) || empty($username) || empty($password)) {
        echo "<script>alert('All fields are required'); window.location.href = 'register.php';</script>";
    } elseif (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format'); window.location.href = 'register.php';</script>";
    } else {
        $pass = md5($password);

        $stmt = $conn->prepare("INSERT INTO tbl_user (name, username, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $username, $pass);

        if ($stmt->execute()) {
            echo "<script>alert('New User Registered Successfully'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'register.php';</script>";
        }
        $stmt->close();
    }
}
?>
