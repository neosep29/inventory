<?php
include('db_config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if (isset($_POST['logout'])) {
    // Unset and destroy the session
    session_unset();
    session_destroy();

    // Redirect to the new login.php
    header("Location: login.php");
}

$userId = $_SESSION['user_id'];
$sql = "SELECT role FROM users WHERE id = $userId";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $userRole = $row['role'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory System</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="index-container">
        <h1 class="inventory-header">Inventory System</h1>
        <div class="box-container">
            <div class="button-container">
                <?php
                if ($userRole === 'admin') {
                    echo '<a class="button" href="add_item.php">Add Item</a>';
                }
                ?>
                <button class="button view-items-button" onclick="location.href='view_items.php'">View Items</button>
                <button class="logout-button" onclick="location.href='logout.php'">Logout</button>
            </div>
            <div id="scanner-container">
                <input type="text" id="scanned-barcode" placeholder="Scan barcode..." autofocus>
                <button type="submit" id="submit-barcode">Submit</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#submit-barcode').on('click', function() {
                console.log('Button clicked'); // Debugging message
                var scannedBarcode = $('#scanned-barcode').val();

                // Send the scanned barcode to the server for verification
                $.ajax({
                    type: 'POST',
                    url: 'barcode_scanner.php',
                    data: { scannedBarcode: scannedBarcode },
                    success: function(response) {
                        console.log('Server response:', response); // Debugging message
                        if (response === 'success') {
                            alert('Item deducted successfully.');
                        } else {
                            alert('Failed to deduct item.');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
