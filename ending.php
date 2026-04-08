<?php
require_once 'includes/session_guard.php';
require_once 'includes/helpers.php';
require_once 'includes/game_logic.php';

$hero       = $_SESSION['hero'] ?? [];
$endingSlug = $_GET['ending'] ?? 'tragic_failure';

$endingMap = [
    'heroic_victory'  => ['label' => 'Heroic Victory', 'css' => 'ending-heroic'],
    'neutral_victory' => ['label' => 'Neutral Victory', 'css' => 'ending-neutral'],
    'tragic_failure'  => ['label' => 'Tragic Failure',  'css' => 'ending-tragic'],
    'secret_path'     => ['label' => 'Secret Path',     'css' => 'ending-secret'],
];

$ending      = $endingMap[$endingSlug] ?? ['label' => 'Unknown Ending', 'css' => 'ending-tragic'];
$finalScore  = !empty($hero) ? calculateScore($hero) : 0;
$summary     = !empty($hero) ? generateHeroSummary($hero, $ending['label']) : '';

if (!empty($hero)) {
    $_SESSION['hero']['score'] = $finalScore;
    $_SESSION['leaderboard'][] = buildLeaderboardEntry($hero, $ending['label']);
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

    <h1 class="ending-title"><?= htmlspecialchars($ending['label']) ?></h1>

    <?php if ($summary): ?>
        <p class="hero-summary"><?= htmlspecialchars($summary) ?></p>
    <?php endif; ?>

    <?php if (!empty($hero)): ?>
    <div class="ending-stats">
        <div class="ending-stat">
            <span class="ending-stat-label">Final score</span>
            <span class="ending-stat-val"><?= $finalScore ?></span>
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