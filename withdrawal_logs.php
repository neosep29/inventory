<?php
include('nav.php');
include('db_config.php'); 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Get the selected item ID from the form
    $item_id = $_POST['item_id'];

    // Insert a record into the withdrawal_logs table
    $sql = "INSERT INTO withdrawal_logs (user_id, item_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $item_id);
    $stmt->execute();
    $stmt->close();

    // Perform additional actions if needed

    // Redirect the user to a relevant page (e.g., index.php)
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Withdraw Item</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <!-- Create a form to allow users to select an item to withdraw -->
    <h2>Withdraw Item</h2>

</body>
</html>
