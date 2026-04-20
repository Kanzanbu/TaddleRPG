<?php
require_once __DIR__ . '/includes/session_guards.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/game_logic.php';

$hero       = $_SESSION['hero'] ?? [];
$endingSlug = $_GET['ending'] ?? 'tragic_failure';

$endingMap = [
    'heroic_victory'  => ['label' => 'Heroic Victory', 'css' => 'ending-heroic',  'pill' => 'pill-heroic'],
    'neutral_victory' => ['label' => 'Neutral Victory', 'css' => 'ending-neutral', 'pill' => 'pill-neutral'],
    'tragic_failure'  => ['label' => 'Tragic Failure',  'css' => 'ending-tragic',  'pill' => 'pill-tragic'],
    'secret_path'     => ['label' => 'Secret Path',     'css' => 'ending-secret',  'pill' => 'pill-secret'],
];

$ending     = $endingMap[$endingSlug] ?? ['label' => 'Unknown Ending', 'css' => 'ending-tragic', 'pill' => 'pill-tragic'];
$finalScore = !empty($hero) ? calculateScore($hero) : 0;
$summary    = !empty($hero) ? generateHeroSummary($hero, $ending['label']) : '';

if (!empty($hero)) {
    $_SESSION['hero']['score'] = $finalScore;
    $_SESSION['leaderboard'][] = buildLeaderboardEntry($hero, $ending['label']);
}

setcookie('taddle_node', '', time() - 1, '/');

$pageTitle = $ending['label'];
$bodyClass = 'ending-page ' . $ending['css'];
require 'includes/layout.php';
?>

<div class="ending-card">
    <p class="ending-eyebrow">Your journey ends here</p>
    <h1 class="ending-title"><?= htmlspecialchars($ending['label']) ?></h1>

    <?php if ($summary): ?>
        <p class="hero-summary"><?= htmlspecialchars($summary) ?></p>
    <?php endif; ?>

    <?php if (!empty($hero)): ?>
    <div class="ending-stats">
        <div class="ending-stat">
            <span class="ending-stat-label">Score</span>
            <span class="ending-stat-val"><?= $finalScore ?></span>
        </div>
        <div class="ending-stat">
            <span class="ending-stat-label">HP left</span>
            <span class="ending-stat-val"><?= $hero['health'] ?? 0 ?></span>
        </div>
        <div class="ending-stat">
            <span class="ending-stat-label">Choices</span>
            <span class="ending-stat-val"><?= count($hero['choices_log'] ?? []) ?></span>
        </div>
    </div>
    <?php endif; ?>

    <div class="ending-actions">
        <a href="leaderboard.php" class="btn btn-primary">Leaderboard</a>
        <a href="create.php" class="btn btn-secondary">Play again</a>
    </div>
</div>

<?php require 'includes/layout_foot.php'; ?>
