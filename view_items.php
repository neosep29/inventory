<!DOCTYPE html>
<html>
<head>
    <title>View Items</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

    </style>
</head>
<body>
    <div class="view-container">
        <h2>View Items</h2>
    </div>
    <table class="view-items-table">
        <tr>
            <th>Item Name</th>
            <th>Description</th>
            <th>Quantity</th>
        </tr>
        <?php
        include('db_config.php');

        $sql = "SELECT name, description, quantity FROM items"; // Updated query
        $result = $conn->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No items found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
    <div class="back-button">
            <a href="index.php">Back to Menu</a>
        </div>
</body>
</html>
