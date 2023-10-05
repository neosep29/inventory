<?php 
include('nav.php');
include('db_config.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
<h1 class="inventory-header">Inventory System</h1>
<div class="add-item-container">
        <h2>Add Item</h2>
        <form class="add-item-form" method="post" action="add_item_process.php">
            <label for="item_name">Item Name:</label>
            <input type="text" name="name" required>
            <label for="description">Description:</label>
            <input type="text" name="description" required>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required>
            <label for="barcode">Barcode:</label>
            <input type="text" name="barcode">
            <button type="submit">Add</button>
        </form>
        <div class="back-button">
            <a href="index.php">Back to Menu</a>
        </div>
    </div>
    <div class="footer">
        <p>&copy; Joseph Patron // <?php echo date("Y"); ?> Inventory System</p>
    </div>
</body>
</html>
