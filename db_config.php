<?php
$db_host = 'localhost:4306';
$db_user = "root";
$db_password = "";
$db_name = 'inventory_db';

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
