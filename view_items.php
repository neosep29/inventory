<?php 
include('nav.php'); 
include('db_config.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

// Define the number of items to display per page
$itemsPerPage = 15;

// Get the current page number from the URL, default to 1 if not provided
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $itemsPerPage;

// Fetch items for the current page
$sql = "SELECT * FROM items LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql);

// Calculate the total number of items
$totalItemsSql = "SELECT COUNT(*) as total FROM items";
$totalItemsResult = $conn->query($totalItemsSql);
$totalItems = $totalItemsResult->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Items</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>

    </style>
</head>
<h1 class="inventory-header">Inventory System</h1>
<body class="view-item-body">
    <h2>View Items</h2>
    <div class="view-container">
            <table class="view-items-table">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <!-- Add more table headers as needed -->
                </tr>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>" . $row["quantity"] . "</td>";
                    // Add more table data cells as needed
                    echo "</tr>";
                }
                ?>
            </table>
    </div>

<div class="pagination">
    <?php
    // Calculate the number of pages
    $totalPages = ceil($totalItems / $itemsPerPage);
    
    // Previous Page button
    if ($page > 1) {
        echo "<a href='view_items.php?page=" . ($page - 1) . "' class='pagination-button'>Previous Page</a>";
    }

    // Next Page button
    if ($page < $totalPages) {
        echo "<a href='view_items.php?page=" . ($page + 1) . "' class='pagination-button'>Next Page</a>";
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
