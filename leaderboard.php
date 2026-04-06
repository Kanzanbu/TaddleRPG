<?php
require_once 'includes/session_guard.php';

$leaderboard = $_SESSION['leaderboard'] ?? [];
usort($leaderboard, fn($a, $b) => $b['score'] <=> $a['score']);

$endingColors = [
    'Heroic Victory'  => 'badge-heroic',
    'Neutral Victory' => 'badge-neutral',
    'Tragic Failure'  => 'badge-tragic',
    'Secret Path'     => 'badge-secret',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard — TaddleRPG</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="leaderboard-page">
<div class="leaderboard-wrap">
    <h1 class="leaderboard-title">Leaderboard</h1>
    <p class="leaderboard-sub">Ranked by final score. The city remembers everyone.</p>

    <?php if (empty($leaderboard)): ?>
        <p class="no-entries">No runs completed yet. Finish a game to appear here.</p>
    <?php else: ?>
        <table class="leaderboard-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Player</th>
                    <th>Character</th>
                    <th>Class</th>
                    <th>Score</th>
                    <th>Ending</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaderboard as $rank => $entry): ?>
                <tr class="<?= $rank === 0 ? 'rank-first' : '' ?>">
                    <td class="rank-num"><?= $rank + 1 ?></td>
                    <td><?= htmlspecialchars($entry['username']) ?></td>
                    <td><?= htmlspecialchars($entry['name']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($entry['class'])) ?></td>
                    <td class="score-cell"><?= (int)$entry['score'] ?></td>
                    <td>
                        <span class="ending-badge <?= $endingColors[$entry['ending']] ?? '' ?>">
                            <?= htmlspecialchars($entry['ending']) ?>
                        </span>
                    </td>
                    <td class="date-cell"><?= htmlspecialchars($entry['timestamp']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="lb-actions">
        <a href="create.php" class="btn-primary">Play again</a>
        <a href="logout.php" class="btn-secondary">Log out</a>
    </div>
</div>
</body>
</html>