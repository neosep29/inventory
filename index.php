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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="index-container">
        <h1 class="inventory-header">Inventory System</h1>
        <div class="box-container">
            <div class="button-container">
                <h2>Please Scan your Item</h2>
            </div>
            <div id="scanner-container">
                <input type="text" id="scanned-barcode" placeholder="Scan barcode..." autofocus>
                <button type="button" id="submit-barcode">Submit</button>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; Joseph Patron || <?php echo date("Y"); ?> Inventory System</p>
    </div>

    <script>
    $(document).ready(function() {
        $('#submit-barcode').on('click', function() {
            var scannedBarcode = $('#scanned-barcode').val();

            // Send the scanned barcode to the server for verification
            $.ajax({
                type: 'POST',
                url: 'barcode_scanner.php',
                data: { scannedBarcode: scannedBarcode },
                success: function(response) {
                    if (response === 'success') {
                        alert('Item deducted successfully.');
                        $('#scanned-barcode').val(''); // Clear the input
                    } else {
                        alert('Item not in the database');
                    }
                }
            });
        });
    });
    </script>
</body>
</html>