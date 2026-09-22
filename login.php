<?php
session_start();

if (isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['user_email'] = $email;
        echo json_encode(['success' => true, 'redirect' => 'index.php']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email format on server.']);
    }
    exit;
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> Login page </title>
</head>

<body>
    <h1>Login here</h1>
    <div id="error-message" style="color: red; display: none;"></div>

    <form id="loginForm">
        <label for="email">Email:</label>
        <input type="email" id="email" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" required>
        <br><br>
        <button type="submit">Log in!</button>
    </form>

    <p>Don't have an account yet? <a href="register.php">Register here.</a></p>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = document.getElementById('email').value;
            const passwordInput = document.getElementById('password').value;
            const errorDiv = document.getElementById('error-message');
            const storedEmail = localStorage.getItem('registeredEmail');
            const storedPassword = localStorage.getItem('registeredPassword');

            if (!storedEmail || !storedPassword) {
                errorDiv.textContent = "Account not registered yet. Please register first.";
                errorDiv.style.display = 'block';
                return;
            }

            if (emailInput !== storedEmail) {
                errorDiv.textContent = "Invalid email.";
                errorDiv.style.display = 'block';
                return;
            }

            if (passwordInput !== storedPassword) {
                errorDiv.textContent = "Incorrect password. Please input again.";
                errorDiv.style.display = 'block';
                return;
            }

            errorDiv.style.display = 'none';

            fetch('login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'email=' + encodeURIComponent(emailInput) + '&password=' + encodeURIComponent(passwordInput)
            })

            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    errorDiv.textContent = data.message;
                    errorDiv.style.display = 'block';
                }

            })

            .catch(err => console.error('Error:', err));
        });

    </script>

</body>

</html>