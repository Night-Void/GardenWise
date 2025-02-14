<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('connection.php');

// Redirect to welcome.php if already logged in
if (isset($_SESSION['username'])) {
    header('Location:/gardenwise/home.php');
    exit();
}

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Form validation
    if (empty($username) || empty($password)) {
        echo "<script>alert('Please fill in all fields'); window.location.href = 'login.php';</script>";
    } elseif (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format'); window.location.href = 'login.php';</script>";
    } else {
        // Hashing the password using MD5 for comparison (Note: MD5 is outdated, consider using bcrypt or password_hash)
        $password = md5($password);

        $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['name'] = $row['name'];
            $_SESSION['username'] = $row['username'];
            header('location:/gardenwise/home.php');
            exit();
        } else {
            echo "<script>alert('Invalid Username or Password'); window.location.href = 'login.php';</script>";
        }
        $stmt->close();
    }
}
?>
