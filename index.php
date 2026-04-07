<?php
session_start();
header('Location: ' . (isset($_SESSION['user']) ? 'game.php' : 'register.php'));
exit;