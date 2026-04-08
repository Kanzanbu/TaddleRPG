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

$pageTitle = 'Login';
$bodyClass = 'auth-page';
require 'includes/layout.php';
?>

<div class="auth-lockup">
    <p class="auth-wordmark">TaddleRPG</p>
    <h1 class="auth-title">Welcome Back</h1>
    <p class="auth-subtitle">The city remembers.</p>
</div>

<div class="auth-card">
    <?php if (isset($_GET['registered'])): ?>
        <div class="alert alert-success">Account created. Log in to begin.</div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="auth-form">
        <div class="field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                   autocomplete="username" required
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   autocomplete="current-password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:0.5rem">Enter the city</button>
    </form>

    <p class="auth-switch">New here? <a href="register.php">Create an account</a></p>
</div>

<?php require 'includes/layout_foot.php'; ?>
