<?php
session_start();
require_once 'includes/helpers.php';

if (isset($_SESSION['user'])) {
    header('Location: game.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitise($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $hash     = $_SESSION['users'][$username] ?? '';

    if ($username && $password && $hash && password_verify($password, $hash)) {
        $_SESSION['user'] = $username;
        header('Location: create.php');
        exit;
    }
    $error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — TaddleRPG</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
<div class="auth-card">
    <h1 class="auth-title">TaddleRPG</h1>
    <p class="auth-subtitle">The city remembers. Log back in.</p>

    <?php if (isset($_GET['registered'])): ?>
        <div class="success-message">Account created! Log in to begin.</div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="auth-form">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="btn-primary">Enter the city</button>
    </form>

    <p class="auth-switch">New here? <a href="register.php">Create an account</a></p>
</div>
</body>
</html>