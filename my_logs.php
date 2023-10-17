<?php
include('nav.php');
include('db_config.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Define the number of logs to display per page
$logsPerPage = 15;

// Get the current page number from the URL, default to 1 if not provided
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $logsPerPage;

// Query the database for withdrawal logs of the logged-in user for the current page
$sql = "SELECT w.withdrawal_date, i.name
        FROM withdrawal_logs w
        JOIN items i ON w.item_id = i.id
        WHERE w.user_id = ?
        ORDER BY w.withdrawal_date DESC
        LIMIT $logsPerPage OFFSET $offset";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "Error preparing the query: " . $conn->error;
} else {
    // Bind the user ID parameter
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
    } else {
        echo "Error executing the query: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Logs</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1 class="inventory-header">Inventory System</h1>
    <h2>My Withdrawal Logs</h2>
    <div class="view-container">
        <table class="view-items-table">
            <tr>
                <th>Item Name</th>
                <th>Withdrawal Date</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["withdrawal_date"] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php
        // Calculate the total number of logs for this user
        $totalLogsSql = "SELECT COUNT(*) as total FROM withdrawal_logs WHERE user_id = $user_id";
        $totalLogsResult = $conn->query($totalLogsSql);
        $totalLogs = $totalLogsResult->fetch_assoc()['total'];
        
        // Calculate the number of pages
        $totalPages = ceil($totalLogs / $logsPerPage);

        // Previous Page button
        if ($page > 1) {
            echo "<a href='my_logs.php?page=" . ($page - 1) . "' class='pagination-button'>Previous Page</a>";
        }

        // Next Page button
        if ($page < $totalPages) {
            echo "<a href='my_logs.php?page=" . ($page + 1) . "' class='pagination-button'>Next Page</a>";
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
