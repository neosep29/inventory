<?php
include('nav.php');
include('db_config.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    // Query the database to check the old password
    $sql = "SELECT password FROM users WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Error preparing the query: " . $conn->error;
    } else {
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $hashed_password = $row['password'];

                // Verify old password
                if (password_verify($old_password, $hashed_password)) {
                    // Update the password with the new one
                    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_sql = "UPDATE users SET password = ? WHERE id = ?";
                    $update_stmt = $conn->prepare($update_sql);

                    if ($update_stmt === false) {
                        echo "Error preparing the update query: " . $conn->error;
                    } else {
                        $update_stmt->bind_param("si", $new_hashed_password, $user_id);

                        if ($update_stmt->execute()) {
                            $success_message = "Password updated successfully.";
                        } else {
                            $error_message = "Error updating the password: " . $update_stmt->error;
                        }
                    }
                } else {
                    $error_message = "Incorrect old password.";
                }
            }
        } else {
            echo "Error executing the query: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1 class="inventory-header">Inventory System</h1>
    <div class="add-item-container">
        <form class ="add-item-form" method="post" action="change_password.php">
            <h2>Change Password</h2>
            <label for="old_password">Old Password:</label>
            <input type="password" name="old_password" required>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required>
            <button type="submit">Change Password</button>
        </form>
        <?php
        if (isset($success_message)) {
            echo '<p class="success-message">' . $success_message . '</p>';
        }
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>
    </div>

    <div class="back-button">
        <a href="index.php">Back to Menu</a>
    </div>
    <div class="footer">
        <p>&copy; Joseph Patron || <?php echo date("Y"); ?> Inventory System</p>
    </div>
</body>
</html>
