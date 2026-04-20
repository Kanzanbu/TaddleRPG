<?php
require_once __DIR__ . '/includes/session_guards.php';

$leaderboard = $_SESSION['leaderboard'] ?? [];
usort($leaderboard, fn($a, $b) => $b['score'] <=> $a['score']);

$pillMap = [
    'Heroic Victory'  => 'pill-heroic',
    'Neutral Victory' => 'pill-neutral',
    'Tragic Failure'  => 'pill-tragic',
    'Secret Path'     => 'pill-secret',
];

$pageTitle = 'Leaderboard';
$bodyClass = 'leaderboard-page';
require 'includes/layout.php';
?>

<div class="leaderboard-wrap">
    <div class="lb-header">
        <h1 class="lb-title">Leaderboard</h1>
        <p class="lb-subtitle">Ranked by final score. The city remembers everyone.</p>
    </div>

    <?php if (empty($leaderboard)): ?>
        <p class="lb-empty">No runs completed yet. Finish a game to appear here.</p>
    <?php else: ?>
        <table class="lb-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Player</th>
                    <th>Character</th>
                    <th>Class</th>
                    <th>Score</th>
                    <th>Faction</th>
                    <th>Ending</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaderboard as $rank => $entry):
                    $isMine = ($entry['username'] ?? '') === ($_SESSION['user'] ?? '');
                ?>
                <tr class="<?= $rank === 0 ? 'lb-rank-1' : '' ?> <?= $isMine ? 'lb-mine' : '' ?>">
                    <td class="td-rank"><?= $rank + 1 ?></td>
                    <td><?= htmlspecialchars($entry['username'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($entry['name'] ?? '—') ?></td>
                    <td><?= htmlspecialchars(ucfirst($entry['class'] ?? '—')) ?></td>
                    <td class="td-score"><?= (int)($entry['score'] ?? 0) ?></td>
                    <td class="td-faction"><?= htmlspecialchars(ucfirst($entry['faction'] ?? '—')) ?></td>
                    <td>
                        <span class="ending-pill <?= $pillMap[$entry['ending'] ?? ''] ?? '' ?>">
                            <?= htmlspecialchars($entry['ending'] ?? '—') ?>
                        </span>
                    </td>
                    <td class="td-date"><?= htmlspecialchars($entry['timestamp'] ?? '—') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="lb-actions">
        <a href="create.php" class="btn btn-primary">Play again</a>
        <a href="logout.php" class="btn btn-secondary">Log out</a>
    </div>
</div>

<?php require 'includes/layout_foot.php'; ?>