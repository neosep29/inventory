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
    <title>Add Item</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h2>Add Item</h2>
    <form method="post" action="add_item_process.php">
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <label for="description">Description:</label>
        <textarea name="description"></textarea>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required>
        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" required>
        <button type="submit">Add Item</button>
    </form>
</body>
</html>