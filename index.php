<?php
include('db_config.php'); 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Inventory System</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1>Inventory System</h1>
    <div class="menu">
        <a href="add_item.php">Add Item</a>
        <a href="view_items.php">View Items</a>
    </div>
</body>
</html>