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

$pageTitle = 'Register';
$bodyClass = 'auth-page';
require 'includes/layout.php';
?>

<div class="auth-lockup">
    <p class="auth-wordmark">TaddleRPG</p>
    <h1 class="auth-title">Enter the City</h1>
    <p class="auth-subtitle">Create your account to begin.</p>
</div>

<div class="auth-card">
    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php" class="auth-form">
        <div class="field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" maxlength="20"
                   autocomplete="username" required
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" minlength="6"
                   autocomplete="new-password" required>
        </div>
        <div class="field">
            <label for="confirm">Confirm password</label>
            <input type="password" id="confirm" name="confirm" minlength="6"
                   autocomplete="new-password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:0.5rem">Create account</button>
    </form>

    <p class="auth-switch">Already have an account? <a href="login.php">Log in</a></p>
</div>

<?php require 'includes/layout_foot.php'; ?>
