<!-- admin_dashboard.php -->
<?php
include('nav.php');
include('db_config.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if ($_SESSION['user_role'] !== 'admin') {
    // Redirect non-admin users to the main page or display an error message
    header("Location: index.php");
}

// Process the role change for individual users
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id']) && isset($_POST['new_role'])) {
        $user_id = (int)$_POST['user_id']; // Sanitize the input
        $new_role = ($_POST['new_role'] === 'admin') ? 'admin' : 'user'; // Sanitize the input
        
        // Update the user's role in the database
        $sql = "UPDATE users SET role = '$new_role' WHERE id = $user_id";
        $conn->query($sql);
    }
}

// Retrieve and display user roles from the database
$sql = "SELECT id, username, role FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1 class="inventory-header">Admin Dashboard</h1>
    <table>
        <tr>
            <th>User</th>
            <th>Role</th>
            <th>Change Role</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["role"] . "</td>";
            echo '<td>
                    <form method="POST">
                        <input type="hidden" name="user_id" value="'.$row["id"].'">
                        <select name="new_role">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <input type="submit" value="Change Role">
                    </form>
                </td>';
            echo "</tr>";
        }
        ?>
    </table>
    <div class="back-button">
        <a href="index.php" id="refresh-link">Back to Menu</a>
    </div>
    <div class="footer">
        <p>&copy; Joseph Patron || <?php echo date("Y"); ?> Inventory System</p>
    </div>
</body>
</html>