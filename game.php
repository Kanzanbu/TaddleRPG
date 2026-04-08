<?php
require_once 'includes/session_guard.php';
require_once 'includes/helpers.php';
require_once 'includes/story_tree.php';
require_once 'includes/game_logic.php';

$error = '';

if (!validateSession()) {
    repairSession();
}

if (!isset($_SESSION['node']) && !empty($_COOKIE['taddle_node'])) {
    $saved = $_COOKIE['taddle_node'];
    if (isset($storyTree[$saved])) {
        $_SESSION['node'] = $saved;
    } else {
        setcookie('taddle_node', '', time() - 1, '/');
        $_SESSION['node'] = 'node_01';
    }
}

if (!isset($_SESSION['node'])) {
    $_SESSION['node'] = 'node_01';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $choiceId = trim($_POST['choice_id'] ?? '');
    $nodeId   = $_SESSION['node'];
    $node     = $storyTree[$nodeId] ?? null;

    if (!$node) {
        $error = 'Story node not found. Please refresh.';
    } else {
        $validIds = array_column($node['choices'], 'id');

        if (!in_array($choiceId, $validIds, true)) {
            $error = 'Invalid choice.';
        } else {
            $choice = $node['choices'][array_search($choiceId, $validIds)];

            if (isChoiceLocked($choice, $_SESSION['hero'])) {
                $error = getLockedMessage($choice, $_SESSION['hero']);
            } else {
                applyStatCost($choice, $_SESSION['hero']);

                $_SESSION['hero']['choices_log'][] = [
                    'node'   => $nodeId,
                    'choice' => $choice['text'],
                ];

                $_SESSION['node'] = $choice['next'];
                setcookie('taddle_node', $choice['next'], time() + (86400 * 7), '/');

                if ($_SESSION['hero']['health'] <= 0) {
                    header('Location: ending.php?ending=tragic_failure');
                    exit;
                }

                $next = $storyTree[$choice['next']] ?? null;
                if (!empty($next['terminal'])) {
                    $ending = resolveEnding($_SESSION['hero']);
                    header('Location: ending.php?ending=' . urlencode($ending));
                    exit;
                }

                header('Location: game.php');
                exit;
            }
        }
    }
}

$nodeId   = $_SESSION['node'];
$node     = $storyTree[$nodeId] ?? null;
$hero     = $_SESSION['hero'];
$progress = getGameProgress($hero, $storyTree);
$dominant = resolveDominantFaction($hero);

$pageTitle = 'TaddleRPG';
$bodyClass = 'game-page';
require 'includes/layout.php';
?>

<div class="game-layout">

    <div class="game-topbar">
        <span class="topbar-brand">TaddleRPG</span>
        <span class="topbar-player"><?= htmlspecialchars($hero['name']) ?> · <?= ucfirst($hero['class']) ?></span>
        <span class="topbar-score"><?= $hero['score'] ?> pts</span>
    </div>

    <main class="story-panel">
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($node): ?>
            <div class="node-container">
                <div class="node-act">Act</div>
                <p class="story-text"><?= htmlspecialchars($node['text']) ?></p>
            </div>

            <div class="choices">
                <?php foreach ($node['choices'] as $choice): ?>
                    <?php
                        $locked  = isChoiceLocked($choice, $hero);
                        $preview = getConsequencePreview($choice);
                        $msg     = $locked ? getLockedMessage($choice, $hero) : '';
                    ?>
                    <div class="choice-wrapper <?= $locked ? 'choice-locked' : '' ?>">
                        <form method="POST" action="game.php" class="choice-form">
                            <input type="hidden" name="choice_id" value="<?= htmlspecialchars($choice['id']) ?>">
                            <button type="submit"
                                    class="choice-btn <?= $locked ? 'btn-locked' : '' ?>"
                                    <?= $locked ? 'disabled' : '' ?>>
                                <?= htmlspecialchars($choice['text']) ?>
                            </button>
                        </form>
                        <p class="consequence-preview">
                            <?= $locked
                                ? '✕ ' . htmlspecialchars($msg)
                                : '› ' . htmlspecialchars($preview) ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="progress-wrap">
                <div class="progress-track">
                    <div class="progress-fill" style="width:<?= $progress['percent'] ?>%"></div>
                </div>
                <p class="progress-label"><?= $progress['visited'] ?> / <?= $progress['total'] ?> nodes visited</p>
            </div>
        <?php else: ?>
            <p>Node not found. <a href="game.php">Refresh</a></p>
        <?php endif; ?>
    </main>

    <aside class="stat-sidebar">

        <div class="sidebar-section">
            <p class="sidebar-heading">Character</p>
            <p class="hero-name"><?= htmlspecialchars($hero['name']) ?></p>
            <span class="hero-class class-<?= $hero['class'] ?>"><?= ucfirst($hero['class']) ?></span>

            <div class="stat-row">
                <span class="stat-label">HP</span>
                <div class="stat-track"><div class="stat-fill fill-hp" style="width:<?= $hero['health'] ?>%"></div></div>
                <span class="stat-val"><?= $hero['health'] ?></span>
            </div>
            <div class="stat-row">
                <span class="stat-label">STR</span>
                <div class="stat-track"><div class="stat-fill fill-str" style="width:<?= min(100, $hero['strength']) ?>%"></div></div>
                <span class="stat-val"><?= $hero['strength'] ?></span>
            </div>
            <?php if ($hero['mana'] > 0 || $hero['class'] === 'mage'): ?>
            <div class="stat-row">
                <span class="stat-label">MANA</span>
                <div class="stat-track"><div class="stat-fill fill-mana" style="width:<?= min(100, $hero['mana']) ?>%"></div></div>
                <span class="stat-val"><?= $hero['mana'] ?></span>
            </div>
            <?php endif; ?>

            <div class="score-line">
                <span><?= $hero['score'] ?> pts</span>
                <span class="score-projected">→ <?= calculateScore($hero) ?> projected</span>
            </div>
        </div>

        <div class="sidebar-section">
            <p class="sidebar-heading">Faction Trust</p>
            <?php foreach ($hero['faction_trust'] as $faction => $trust): ?>
            <div class="stat-row">
                <span class="stat-label <?= $faction === $dominant ? 'is-dominant' : '' ?>">
                    <?= ucfirst($faction) ?>
                </span>
                <div class="stat-track"><div class="stat-fill fill-faction" style="width:<?= $trust ?>%"></div></div>
                <span class="stat-val"><?= $trust ?></span>
            </div>
            <?php endforeach; ?>
            <?php if ($dominant !== 'none'): ?>
                <p class="faction-dominant-label">Leading: <span><?= ucfirst($dominant) ?></span></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($hero['inventory'])): ?>
        <div class="sidebar-section">
            <p class="sidebar-heading">Inventory</p>
            <ul class="inventory-list">
                <?php foreach ($hero['inventory'] as $item): ?>
                    <li><?= htmlspecialchars(ucwords(str_replace('_', ' ', $item))) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($hero['choices_log'])): ?>
        <div class="sidebar-section">
            <p class="sidebar-heading">Your Path</p>
            <ol class="choice-log">
                <?php foreach ($hero['choices_log'] as $entry): ?>
                    <li><?= htmlspecialchars($entry['choice']) ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
        <?php endif; ?>

    </aside>

</div>

<?php require 'includes/layout_foot.php'; ?>
