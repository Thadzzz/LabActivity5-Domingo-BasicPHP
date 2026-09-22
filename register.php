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
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> Registration page </title>
</head>

<body>

    <h1>Register here</h1>
    <div id="error-message" style="color: red; display: none;"></div>

    <form id="registerForm">
        <label for="email">Email:</label>
        <input type="email" id="email" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" required>
        <br><br>
        <button type="submit">Register!</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here.</a></p>

    <script>

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorDiv = document.getElementById('error-message');

            fetch('register.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password)
            })

            .then(res => res.json())
            .then(data => {

                if (data.success) {
                    localStorage.setItem('registeredEmail', email);
                    localStorage.setItem('registeredPassword', password);
                    alert('Account registered! You can now login.');

                    window.location.href = 'login.php';
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