<?php
include('nav.php');
include('db_config.php'); 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$userRole = $_SESSION['user_role'];
if ($userRole !== 'admin') {
    // Redirect non-admin users to the main page or display an error message
    header("Location: index.php");
}

// Define the number of logs to display per page
$logsPerPage = 15;

// Get the current page number from the URL, default to 1 if not provided
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $logsPerPage;

// Retrieve and display withdrawal logs with pagination
$sql = "SELECT w.withdrawal_date, u.username, i.name 
        FROM withdrawal_logs w 
        JOIN users u ON w.user_id = u.id 
        JOIN items i ON w.item_id = i.id 
        ORDER BY w.withdrawal_date DESC
        LIMIT $logsPerPage OFFSET $offset";

$stmt = $conn->prepare($sql);
$logs = [];

if ($stmt !== false) {
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }
    } else {
        echo "Error executing the query: " . $stmt->error;
    }
}

// Calculate the total number of logs
$totalLogsSql = "SELECT COUNT(*) as total FROM withdrawal_logs";
$totalLogsResult = $conn->query($totalLogsSql);
$totalLogs = $totalLogsResult->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>

    </style>
</head>
<body>
<h1 class="inventory-header">Inventory System</h1>
    <h2>Withdrawal Logs</h2>
    <table class="admin-logs-table">
        <tr>
            <th>User</th>
            <th>Item</th>
            <th>Withdrawal Date</th>
        </tr>
        <?php
        foreach ($logs as $log) {
            echo "<tr>";
            echo "<td>" . $log["username"] . "</td>";
            echo "<td>" . $log["name"] . "</td>";
            echo "<td>" . $log["withdrawal_date"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <div class="pagination">
        <?php
        // Calculate the number of pages
        $totalPages = ceil($totalLogs / $logsPerPage);
        
        // Previous Page button
        if ($page > 1) {
            echo "<a href='admin.php?page=" . ($page - 1) . "' class='pagination-button'>Previous Page</a>";
        }

        // Next Page button
        if ($page < $totalPages) {
            echo "<a href='admin.php?page=" . ($page + 1) . "' class='pagination-button'>Next Page</a>";
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
