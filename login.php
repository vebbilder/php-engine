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

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        redirect(SITE_URL . ($user['is_admin'] ? '/admin' : ''));
    } else {
        $error = "Invalid email or password";
    }
}

$title = "Login";
$content = "
<h2>Login</h2>
" . ($error ? "<p style='color: red;'>$error</p>" : "") . "
<form method='post'>
    <label for='email'>Email:</label>
    <input type='email' id='email' name='email' required>

    <label for='password'>Password:</label>
    <input type='password' id='password' name='password' required>

    <button type='submit'>Login</button>
</form>
<p>Don't have an account? <a href='" . SITE_URL . "/register'>Register here</a></p>
";

require "templates/default.php";
?>