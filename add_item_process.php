<?php
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $barcode = $_POST['barcode'];

    $sql = "INSERT INTO items (name, description, quantity, barcode) VALUES ('$name', '$description', $quantity, $barcode)";
    if ($conn->query($sql) === TRUE) {
        header("Location: view_items.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
