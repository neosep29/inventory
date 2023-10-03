<?php
include('db_config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];
    
        // Debugging output
        echo "Entered Username: $username<br>";
        echo "Hashed Password from the Database: $hashed_password<br>";
    
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $row["id"];
            header("Location: index.php");
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Username not found.";
    }
}

$conn->close();
?>
