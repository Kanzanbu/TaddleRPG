<?php
// includes/game_logic.php

require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/story_tree.php';

function calculateScore(array $hero): int {
    $base    = $hero['score'];
    $hpBonus = (int) floor($hero['health'] / 10);

    $factionBonus = 0;
    foreach ($hero['faction_trust'] as $trust) {
        if ($trust >= 75) $factionBonus += 15;
        elseif ($trust >= 50) $factionBonus += 5;
    }

    $inventoryBonus = count($hero['inventory']) * 10;

    return $base + $hpBonus + $factionBonus + $inventoryBonus;
}

function resolveDominantFaction(array $hero): string {
    $trust = $hero['faction_trust'];
    arsort($trust);
    $top = array_key_first($trust);

    if ($trust[$top] < 40) {
        return 'none';
    }
    return $top;
}

function resolveEnding(array $hero): string {
    $faction = resolveDominantFaction($hero);

    if (in_array('guild_documents', $hero['inventory'], true) && $hero['score'] >= 100) {
        return 'secret_path';
    }
    if ($faction === 'vipers' && $hero['faction_trust']['vipers'] >= 70) {
        return 'heroic_victory';
    }
    if ($faction === 'guild' && $hero['faction_trust']['guild'] >= 70) {
        return 'heroic_victory';
    }
    if ($faction === 'watch' && $hero['faction_trust']['watch'] >= 70) {
        return 'heroic_victory';
    }
    if ($hero['health'] <= 0) {
        return 'tragic_failure';
    }
    return 'neutral_victory';
}

function validateSession(): bool {
    if (!isset($_SESSION['user'])) return false;
    if (!isset($_SESSION['hero'])) return false;
    if (!isset($_SESSION['node'])) return false;

    $required = ['name', 'class', 'health', 'strength', 'mana', 'inventory', 'score', 'choices_log', 'faction_trust'];
    foreach ($required as $key) {
        if (!array_key_exists($key, $_SESSION['hero'])) return false;
    }

    foreach (['vipers', 'guild', 'watch'] as $f) {
        if (!array_key_exists($f, $_SESSION['hero']['faction_trust'])) return false;
    }

    if (!in_array($_SESSION['hero']['class'], ['warrior', 'mage', 'rogue'], true)) return false;

    return true;
}

function repairSession(): void {
    if (!isset($_SESSION['hero'])) {
        $_SESSION['hero'] = [];
    }

    $defaults = [
        'name'          => 'Unknown',
        'class'         => 'rogue',
        'health'        => 70,
        'strength'      => 25,
        'mana'          => 10,
        'inventory'     => [],
        'score'         => 0,
        'choices_log'   => [],
        'faction_trust' => ['vipers' => 50, 'guild' => 50, 'watch' => 50],
    ];

    foreach ($defaults as $key => $value) {
        if (!array_key_exists($key, $_SESSION['hero'])) {
            $_SESSION['hero'][$key] = $value;
        }
    }

    foreach (['vipers', 'guild', 'watch'] as $f) {
        if (!isset($_SESSION['hero']['faction_trust'][$f])) {
            $_SESSION['hero']['faction_trust'][$f] = 50;
        }
    }

    $_SESSION['hero']['health'] = max(0, min(100, (int) $_SESSION['hero']['health']));

    if (!isset($_SESSION['node'])) {
        $_SESSION['node'] = 'node_01';
    }
}

function getGameProgress(array $hero, array $storyTree): array {
    $totalNodes    = count(array_filter($storyTree, fn($n) => empty($n['terminal'])));
    $visitedNodes  = count(array_unique(array_column($hero['choices_log'], 'node')));
    $percent       = $totalNodes > 0 ? (int) round(($visitedNodes / $totalNodes) * 100) : 0;

    return [
        'visited'  => $visitedNodes,
        'total'    => $totalNodes,
        'percent'  => $percent,
    ];
}

function buildLeaderboardEntry(array $hero, string $endingLabel): array {
    return [
        'username'  => $_SESSION['user'] ?? 'Unknown',
        'name'      => sanitise($hero['name']),
        'class'     => $hero['class'],
        'score'     => calculateScore($hero),
        'ending'    => $endingLabel,
        'health'    => $hero['health'],
        'faction'   => resolveDominantFaction($hero),
        'choices'   => count($hero['choices_log']),
        'timestamp' => date('Y-m-d H:i'),
    ];
}

function resetHeroSession(): void {
    unset($_SESSION['hero'], $_SESSION['node']);
    setcookie('taddle_node', '', time() - 1, '/');
}