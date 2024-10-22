<?php
require_once 'core/config.php';
require_once 'core/functions.php';

if (is_logged_in()) {
    redirect(SITE_URL);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email already exists";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->execute([$email, $hashed_password]);

            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['is_admin'] = 0;
            redirect(SITE_URL);
        }
    }
}

$title = "Register";
$content = "
<h2>Register</h2>
" . ($error ? "<p style='color: red;'>$error</p>" : "") . "
<form method='post'>
    <label for='email'>Email:</label>
    <input type='email' id='email' name='email' required>

    <label for='password'>Password:</label>
    <input type='password' id='password' name='password' required>

    <label for='confirm_password'>Confirm Password:</label>
    <input type='password' id='confirm_password' name='confirm_password' required>

    <button type='submit'>Register</button>
</form>
<p>Already have an account? <a href='" . SITE_URL . "/login'>Login here</a></p>
";

require "templates/default.php";
?>