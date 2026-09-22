<?php
session_start();

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php');
    exit;
}

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
    <title> Home page </title>
</head>

<body>
    <h1>Welcome to the home page!</h1>
    <p>Currently logged in as: <strong><?php echo htmlspecialchars($userEmail); ?></strong></p>

    <a href="index.php?action=logout">Logout</a>

    <br><br>

    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">Free robux</a>

</body>

</html>