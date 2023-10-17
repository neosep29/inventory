<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav>
    <div class="topnav">
    <img src="css/GS-logo.png" alt="Your Logo" class="top-nav-logo">
    <span class="center-text">UPLB Graduate School</span>
    </div>
    <div class="sidenav" id="sidebar">
        <button id="sidebar-toggle"><i class="fas fa-bars"></i></button>
        <ul>
            <li><a href="index.php" title="Home"><i class="fas fa-home"></i> Home</a></li>
            <?php
            // Check if the user is an admin and display the "Add Item" link
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                echo '<li><a href="add_item.php" title="Add Item"><i class="fa-regular fa-square-plus"></i> Add Item</a></li>';
                echo '<li><a href="admin.php" title="Withdrawal Logs"><i class="fa-solid fa-barcode"></i> Withdrawal Logs</a></li>';
            }
            // Add a button to view the user's own logs
            if (isset($_SESSION['user_id'])) {
                echo '<li><a href="my_logs.php" title="View My Logs"><i class="fas fa-book"></i> View My Logs</a></li>';
            }
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                echo '<li><a href="users_list.php" title="Users List"><i class="fas fa-users"></i>Users List</a></li>';
            }
            ?>
            <li><a href="view_items.php" title="View Items"><i class="fas fa-list"></i> View Items</a></li>
            <li><a href="change_password.php" title="Change Password"><i class="fa-solid fa-key"></i> Change Password</a></li>
        </ul>
        <ul class="logout">
            <li><a href="logout.php" title="Logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div id="sideNavOverlay"></div>
    <button id="sidebar-toggle" class="hamburger-button">
        <i class="fas fa-bars"></i>
    </button>
</nav>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="script.js"></script>
</html>