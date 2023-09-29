<?php
include('db_config.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$sql = "SELECT * FROM items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Items</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h2>View Items</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "No items in the inventory.";
        }
        $conn->close();
        ?>
    </table>
    <a href="index.php">Back to Menu</a>
</body>
</html>