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

// Get the current page number from the URL or default to page 1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset to start fetching records
$offset = ($page - 1) * $logsPerPage;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<h1 class="inventory-header">Inventory System</h1>
    <h2>Withdrawal Logs</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Item</th>
            <th>Withdrawal Date</th>
        </tr>
        <?php
        // Retrieve and display withdrawal logs with pagination
        $sql = "SELECT w.withdrawal_date, u.username, i.name 
        FROM withdrawal_logs w 
        JOIN users u ON w.user_id = u.id 
        JOIN items i ON w.item_id = i.id 
        ORDER BY w.withdrawal_date DESC
        LIMIT $offset, $logsPerPage";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing the query: " . $conn->error;
        } else {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    // Format the timestamp to include month, date, year, and 12-hour time format
                    $formattedDate = date("M j, Y g:i A", strtotime($row["withdrawal_date"]));
                    echo "<td>" . $formattedDate . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "Error executing the query: " . $stmt->error;
            }
        }
        ?>
    </table>

    <!-- Create pagination links -->
    <div class="pagination">
        <?php
        // Calculate the total number of withdrawal logs
        $totalLogs = $conn->query("SELECT COUNT(*) FROM withdrawal_logs")->fetch_row()[0];

        // Calculate the total number of pages
        $totalPages = ceil($totalLogs / $logsPerPage);

        // Create "Previous" and "Next" buttons if there are more pages
        if ($page > 1) {
            echo "<a href='admin.php?page=" . ($page - 1) . "'>Previous Page</a>";
        }
        if ($page < $totalPages) {
            echo "<a href='admin.php?page=" . ($page + 1) . "'>Next Page</a>";
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
