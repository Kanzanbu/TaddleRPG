<?php
require_once 'includes/session_guard.php';
require_once 'includes/helpers.php';

$hero       = $_SESSION['hero'] ?? [];
$endingSlug = $_GET['ending'] ?? 'tragic_failure';

$endingMap = [
    'heroic_victory'  => ['label' => 'Heroic Victory', 'css' => 'ending-heroic'],
    'neutral_victory' => ['label' => 'Neutral Victory', 'css' => 'ending-neutral'],
    'tragic_failure'  => ['label' => 'Tragic Failure',  'css' => 'ending-tragic'],
    'secret_path'     => ['label' => 'Secret Path',     'css' => 'ending-secret'],
    'tragic'          => ['label' => 'Tragic Failure',  'css' => 'ending-tragic'],
];

$ending = $endingMap[$endingSlug] ?? ['label' => 'Unknown Ending', 'css' => 'ending-tragic'];
$summary = !empty($hero) ? generateHeroSummary($hero, $ending['label']) : '';

if (!empty($hero)) {
    $_SESSION['leaderboard'][] = [
        'username'  => $_SESSION['user'] ?? 'Unknown',
        'name'      => $hero['name'] ?? '—',
        'class'     => $hero['class'] ?? '—',
        'score'     => $hero['score'] ?? 0,
        'ending'    => $ending['label'],
        'timestamp' => date('Y-m-d H:i'),
    ];
}

setcookie('taddle_node', '', time() - 1, '/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($ending['label']) ?> — TaddleRPG</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="ending-page <?= $ending['css'] ?>">
<div class="ending-card">

    <div class="ending-title-wrap">
        <h1 class="ending-title"><?= htmlspecialchars($ending['label']) ?></h1>
    </div>

    <?php if ($summary): ?>
        <p class="hero-summary"><?= htmlspecialchars($summary) ?></p>
    <?php endif; ?>

    <?php if (!empty($hero)): ?>
    <div class="ending-stats">
        <div class="ending-stat">
            <span class="ending-stat-label">Final score</span>
            <span class="ending-stat-val"><?= $hero['score'] ?? 0 ?></span>
        </div>
        <div class="ending-stat">
            <span class="ending-stat-label">HP remaining</span>
            <span class="ending-stat-val"><?= $hero['health'] ?? 0 ?></span>
        </div>
        <div class="ending-stat">
            <span class="ending-stat-label">Choices made</span>
            <span class="ending-stat-val"><?= count($hero['choices_log'] ?? []) ?></span>
        </div>
    </div>
    <?php endif; ?>

    <div class="ending-actions">
        <a href="leaderboard.php" class="btn-primary">View leaderboard</a>
        <a href="create.php" class="btn-secondary">Play again</a>
    </div>
</div>
</body>
</html>