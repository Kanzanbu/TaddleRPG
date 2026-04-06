<?php
require_once 'includes/session_guard.php';
require_once 'includes/helpers.php';

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
    'warrior' => ['label' => 'Warrior', 'stats' => 'HP 100 · STR 40 · MANA 0',  'desc' => 'Brute force and intimidation. Unlocks combat-heavy paths.'],
    'mage'    => ['label' => 'Mage',    'stats' => 'HP 60 · STR 15 · MANA 45',  'desc' => 'Arcane insight. Low HP but exclusive Mage-only choices.'],
    'rogue'   => ['label' => 'Rogue',   'stats' => 'HP 70 · STR 25 · MANA 10',  'desc' => 'Stealth and deception. The natural fit for a city of secrets.'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Path — TaddleRPG</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
<div class="create-card">
    <h1 class="auth-title">Who are you?</h1>
    <p class="auth-subtitle">Your name and class shape every choice ahead.</p>

    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="create.php" class="auth-form">
        <label for="name">Character name</label>
        <input type="text" id="name" name="name" maxlength="30" required
               placeholder="e.g. Kira"
               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

        <label>Choose your class</label>
        <div class="class-grid">
            <?php foreach ($classInfo as $key => $info): ?>
            <label class="class-option">
                <input type="radio" name="class" value="<?= $key ?>"
                       <?= (($_POST['class'] ?? 'rogue') === $key) ? 'checked' : '' ?>>
                <strong><?= $info['label'] ?></strong>
                <span class="class-stats"><?= $info['stats'] ?></span>
                <span class="class-desc"><?= $info['desc'] ?></span>
            </label>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn-primary">Enter the city</button>
    </form>
</div>
</body>
</html>