<?php
session_start();

if (isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    
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
    <title>Login - Lab 5</title>
</head>
<body>
    <h1>Login</h1>
    <div id="error-message" style="color: red; display: none;"></div>
    
    <form id="loginForm">
        <label for="email">Email:</label>
        <input type="email" id="email" required>
        <button type="submit">Login</button>
    </form>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = document.getElementById('email').value;
            const errorDiv = document.getElementById('error-message');
            const storedEmail = localStorage.getItem('registeredEmail');

            if (!storedEmail) {
                errorDiv.textContent = "No account registered yet. Please register first.";
                errorDiv.style.display = 'block';
                return;
            }

            if (emailInput !== storedEmail) {
                errorDiv.textContent = "Incorrect email. Please try again.";
                errorDiv.style.display = 'block';
                return;
            }

            errorDiv.style.display = 'none';

            fetch('login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'email=' + encodeURIComponent(emailInput)
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