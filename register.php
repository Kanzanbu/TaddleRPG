<?php
session_start();
require_once 'includes/helpers.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitise($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm']  ?? '';

    if (!$username || !$password) {
        $error = 'Username and password are required.';
    } elseif (strlen($username) < 3 || strlen($username) > 20) {
        $error = 'Username must be 3–20 characters.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (isset($_SESSION['users'][$username])) {
        $error = 'That username is already taken.';
    } else {
        $_SESSION['users'][$username] = password_hash($password, PASSWORD_DEFAULT);
        header('Location: login.php?registered=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — TaddleRPG</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
<div class="auth-card">
    <h1 class="auth-title">TaddleRPG</h1>
    <p class="auth-subtitle">Create your account to enter the city of secrets.</p>

    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php" class="auth-form">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" maxlength="20" required
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" minlength="6" required>

        <label for="confirm">Confirm password</label>
        <input type="password" id="confirm" name="confirm" minlength="6" required>

        <button type="submit" class="btn-primary">Create account</button>
    </form>

    <p class="auth-switch">Already have an account? <a href="login.php">Log in</a></p>
</div>
</body>
</html>