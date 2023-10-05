<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            echo '<li><a href="add_item.php">Add Item</a></li>';
            echo '<li><a href="admin.php">Barcode Scan Logs</a></li>';
        }
        ?>
        <li><a href="view_items.php">View Items</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>
</html>
