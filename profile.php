<?php
require_once 'core/config.php';
require_once 'core/functions.php';

if (!is_logged_in()) {
    redirect(SITE_URL . '/login');
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_new_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hashed_password, $user_id]);
            $success = "Password updated successfully";
        } else {
            $error = "New passwords do not match";
        }
    } else {
        $error = "Current password is incorrect";
    }
}

$title = "User Profile";
$content = "
<h2>User Profile</h2>
<p>Email: {$user['email']}</p>
" . ($error ? "<p style='color: red;'>$error</p>" : "") . "
" . ($success ? "<p style='color: green;'>$success</p>" : "") . "
<h3>Change Password</h3>
<form method='post'>
    <label for='current_password'>Current Password:</label>
    <input type='password' id='current_password' name='current_password' required>

    <label for='new_password'>New Password:</label>
    <input type='password' id='new_password' name='new_password' required>

    <label for='confirm_new_password'>Confirm New Password:</label>
    <input type='password' id='confirm_new_password' name='confirm_new_password' required>

    <button type='submit'>Change Password</button>
</form>
";

require "templates/default.php";
?>