<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

$userEmail = $_SESSION['user_email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Lab 5</title>
</head>
<body>
    <h1>Welcome to the Dashboard</h1>
    <p>You are logged in as: <strong><?php echo htmlspecialchars($userEmail); ?></strong></p>
    
    <a href="logout.php">Logout</a>
</body>
</html>