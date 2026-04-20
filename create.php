<?php
require_once __DIR__ . '/includes/session_guards.php';
require_once __DIR__ . '/includes/helpers.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = sanitise($_POST['name']  ?? '');
    $class = sanitise($_POST['class'] ?? '');

    if (!$name) {
        $error = 'Please enter a character name.';
    } elseif (!in_array($class, ['warrior', 'mage', 'rogue'], true)) {
        $error = 'Please choose a valid class.';
    } else {
        $_SESSION['hero'] = array_merge(getClassStats($class), [
            'name'          => $name,
            'class'         => $class,
            'inventory'     => [],
            'score'         => 0,
            'choices_log'   => [],
            'faction_trust' => ['vipers' => 50, 'guild' => 50, 'watch' => 50],
        ]);
        $_SESSION['node'] = 'node_01';
        setcookie('taddle_node', 'node_01', time() + (86400 * 7), '/');
        header('Location: game.php');
        exit;
    }
}

$classInfo = [
    'warrior' => [
        'label' => 'Warrior',
        'stats' => "HP 100\nSTR 40\nMANA 0",
        'desc'  => 'Brute force and intimidation. Unlocks combat-heavy paths.',
    ],
    'mage' => [
        'label' => 'Mage',
        'stats' => "HP 60\nSTR 15\nMANA 45",
        'desc'  => 'Arcane insight. Low HP but exclusive Mage-only choices.',
    ],
    'rogue' => [
        'label' => 'Rogue',
        'stats' => "HP 70\nSTR 25\nMANA 10",
        'desc'  => 'Stealth and deception. The natural fit for a city of secrets.',
    ],
];

$pageTitle = 'Choose Your Path';
$bodyClass = 'create-page';
require 'includes/layout.php';
?>

<div class="create-card">
    <h1 class="create-title">Who are you?</h1>
    <p class="create-sub">Your name and class shape every choice ahead.</p>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="create.php">
        <div class="field">
            <label for="name">Character name</label>
            <input type="text" id="name" name="name" maxlength="30"
                   required placeholder="e.g. Kira"
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <label style="margin-bottom:0.5rem;display:block">Class</label>
        <div class="class-grid">
            <?php foreach ($classInfo as $key => $info): ?>
            <label class="class-option">
                <input type="radio" name="class" value="<?= $key ?>"
                       <?= (($_POST['class'] ?? 'rogue') === $key) ? 'checked' : '' ?>>
                <span class="class-name"><?= $info['label'] ?></span>
                <span class="class-stats"><?= nl2br(htmlspecialchars($info['stats'])) ?></span>
                <span class="class-desc"><?= htmlspecialchars($info['desc']) ?></span>
            </label>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn btn-primary">Enter the city</button>
    </form>
</div>

<?php require 'includes/layout_foot.php'; ?>
