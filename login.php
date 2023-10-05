<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('db_config.php');

if (isset($_SESSION['user_id'])) {
    $userRole = $_SESSION['user_role'];
    if ($userRole === 'admin') {
        // If the user is an admin, redirect to the main page with a button for barcode logs
        header("Location: index.php");
    } else {
        // If the user is not an admin, redirect to the main page without the barcode logs button
        header("Location: index.php");
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];
        $userRole = $row["role"];

        // Debugging output
        echo "Entered Username: $username<br>";
        echo "Hashed Password from the Database: $hashed_password<br>";

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $row["id"];
            $_SESSION['user_role'] = $userRole;
            header("Location: index.php");
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Username not found.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>LoginUPLB </title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="b1">
    <h1 class="inventory-header">Inventory System</h1>
    <div class="login-container">
        <img src="css/GS-logo.png" alt="Your Logo" class="login-logo">
        <h2>UPLB Graduate School</h2>
        <form method="post" action="login.php">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <?php
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>
        <p class="create-account-link">Don't have an account? <a href="registration.php">Create an account</a></p>
    </div>
    <div class="footer">
        <p>&copy; Joseph Patron || <?php echo date("Y"); ?> Inventory System</p>
    </div>
</body>
</html>
