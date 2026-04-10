<?php
// includes/helpers.php

function sanitise(string $input): string {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function getClassStats(string $class): array {
    return match ($class) {
        'warrior' => ['health' => 100, 'strength' => 40, 'mana' => 0],
        'mage'    => ['health' => 60,  'strength' => 15, 'mana' => 45],
        'rogue'   => ['health' => 70,  'strength' => 25, 'mana' => 10],
        default   => ['health' => 80,  'strength' => 20, 'mana' => 0],
    };
}

function isChoiceLocked(array $choice, array $hero): bool {
    $req = $choice['requires'] ?? [];

    foreach (['health', 'strength', 'mana'] as $stat) {
        if (isset($req[$stat]) && $hero[$stat] < $req[$stat]) {
            return true;
        }
    }
    if (!empty($req['item']) && !in_array($req['item'], $hero['inventory'], true)) {
        return true;
    }
    if (!empty($req['class']) && $hero['class'] !== $req['class']) {
        return true;
    }
    return false;
}

function getLockedMessage(array $choice, array $hero): string {
    $req  = $choice['requires'] ?? [];
    $msgs = [];

    foreach (['strength', 'health', 'mana'] as $stat) {
        if (isset($req[$stat]) && $hero[$stat] < $req[$stat]) {
            $deficit = $req[$stat] - $hero[$stat];
            $msgs[]  = 'Requires ' . $req[$stat] . ' ' . strtoupper($stat)
                     . ' — you have ' . $hero[$stat] . '.'
                     . ' Gain ' . $deficit . ' more to unlock.';
        }
    }
    if (!empty($req['item']) && !in_array($req['item'], $hero['inventory'], true)) {
        $msgs[] = 'Requires: ' . ucfirst($req['item']) . ' (not in inventory).';
    }
    if (!empty($req['class']) && $hero['class'] !== $req['class']) {
        $msgs[] = 'Only available to the ' . ucfirst($req['class']) . ' class.';
    }
    return implode(' ', $msgs) ?: 'Requirements not met.';
}

function applyStatCost(array $choice, array &$hero): void {
    $cost = $choice['stat_cost'] ?? [];

    if (isset($cost['health'])) {
        $hero['health'] = max(0, min(100, $hero['health'] + $cost['health']));
    }
    foreach (['strength', 'mana'] as $stat) {
        if (isset($cost[$stat])) {
            $hero[$stat] = max(0, $hero[$stat] + $cost[$stat]);
        }
    }
    foreach (['vipers', 'guild', 'watch'] as $faction) {
        if (isset($cost[$faction])) {
            $hero['faction_trust'][$faction] = max(0, min(100,
                $hero['faction_trust'][$faction] + $cost[$faction]
            ));
        }
    }
    if (!empty($cost['item']) && !in_array($cost['item'], $hero['inventory'], true)) {
        $hero['inventory'][] = $cost['item'];
    }
    $hero['score'] = max(0, $hero['score'] + ($cost['score'] ?? 10));
}

function getConsequencePreview(array $choice): string {
    if (!empty($choice['ai_preview'])) {
        return $choice['ai_preview'];
    }

    $cost  = $choice['stat_cost'] ?? [];
    $parts = [];

    if (!empty($cost['health'])) {
        $parts[] = $cost['health'] < 0
            ? 'Costs ' . abs($cost['health']) . ' HP'
            : 'Restores ' . $cost['health'] . ' HP';
    }
    if (!empty($cost['strength'])) {
        $parts[] = $cost['strength'] > 0
            ? 'Gain ' . $cost['strength'] . ' STR'
            : 'Lose ' . abs($cost['strength']) . ' STR';
    }
    foreach (['vipers', 'guild', 'watch'] as $f) {
        if (!empty($cost[$f])) {
            $parts[] = $cost[$f] > 0
                ? ucfirst($f) . ' trust +' . $cost[$f]
                : ucfirst($f) . ' trust ' . $cost[$f];
        }
    }
    if (!empty($cost['item'])) {
        $parts[] = 'Adds ' . ucfirst($cost['item']) . ' to inventory';
    }
    return !empty($parts) ? implode('. ', $parts) . '.' : 'No stat impact.';
}

function generateHeroSummary(array $hero, string $endingLabel): string {
    $name  = sanitise($hero['name']);
    $class = ucfirst($hero['class']);
    $top3  = array_slice($hero['choices_log'] ?? [], 0, 3);

    $summary = $name . ' the ' . $class . ' navigated the city of secrets ';

    if (!empty($top3)) {
        $texts   = array_map(fn($c) => '"' . sanitise($c['choice']) . '"', $top3);
        $summary .= 'making key choices: ' . implode(', ', $texts) . '. ';
    }

    $summary .= 'With ' . $hero['health'] . ' HP remaining and a score of '
              . $hero['score'] . ', their journey ended in a ' . $endingLabel . '.';

    return $summary;
}