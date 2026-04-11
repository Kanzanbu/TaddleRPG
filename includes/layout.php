<?php
// includes/layout.php
// Usage:
//   $pageTitle = 'My Page';
//   $bodyClass = 'game-page';
//   require 'includes/layout.php'; // outputs <head> + opening <body>
// At bottom of each page:
//   require 'includes/layout_foot.php';

if (!isset($pageTitle)) $pageTitle = 'TaddleRPG';
if (!isset($bodyClass)) $bodyClass = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> — TaddleRPG</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="<?= htmlspecialchars($bodyClass) ?>">
<a href="#main-content" class="skip-link">Skip to content</a>