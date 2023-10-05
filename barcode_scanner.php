<?php
include('db_config.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $scannedBarcode = $_POST['scannedBarcode'];
    
    // Get the user ID of the logged-in user from the session
    $userId = $_SESSION['user_id'];

    $sql = "SELECT * FROM items WHERE barcode = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $scannedBarcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Barcode exists in the database; deduct the item's quantity here.
        $row = $result->fetch_assoc();
        $itemId = $row['id'];
        $itemQuantity = $row['quantity'];

        if ($itemQuantity > 0) {
            // Deduct the item by decreasing the quantity
            $newQuantity = $itemQuantity - 1;
            $updateSql = "UPDATE items SET quantity = $newQuantity WHERE id = $itemId";
            if ($conn->query($updateSql) === TRUE) {
                // Log the withdrawal in the withdrawal_logs table
                $logSql = "INSERT INTO withdrawal_logs (user_id, item_id) VALUES (?, ?)";
                $logStmt = $conn->prepare($logSql);
                $logStmt->bind_param("ii", $userId, $itemId);
                
                if ($logStmt->execute()) {
                    echo "success";
                } else {
                    echo "Failed to deduct item.";
                }
            } else {
                echo "Failed to deduct item.";
            }
        } else {
            echo "Item out of stock.";
        }
    } else {
        // Barcode not found in the database
        echo "Failed to deduct item.";
    }

    $stmt->close();
}
?>
