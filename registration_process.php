<?php
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $role = "user"; // Default role
    if ($is_admin) {
        $role = "admin"; // For admin users
    }
    
    // Insert the user into the database with the assigned role
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";


    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>