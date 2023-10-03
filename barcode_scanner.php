<?php
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $scannedBarcode = $_POST['scannedBarcode'];

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
                echo "success";
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