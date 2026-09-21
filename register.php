<?php
session_start();
if (isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Lab 5</title>
</head>
<body>
    <h1>Register</h1>
    <form id="registerForm">
        <label for="email">Email:</label>
        <input type="email" id="email" required>
        <button type="submit">Register</button>
    </form>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            localStorage.setItem('registeredEmail', email);
            alert('Account registered! Email saved. You can now login.');
            window.location.href = 'login.php';
        });
    </script>
</body>
</html>