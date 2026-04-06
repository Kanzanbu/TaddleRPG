<?php
// includes/story_tree.php

$storyTree = [

    'node_01' => [
        'id'   => 'node_01',
        'text' => 'You arrive at the city gates as dusk falls. A hooded figure slips you a note: "Meet me at the Crow\'s Tavern — your silence has a price." Three paths open before you.',
        'choices' => [
            [
                'id'         => 'c01a',
                'text'       => 'Head to the Crow\'s Tavern immediately',
                'next'       => 'node_02',
                'requires'   => [],
                'stat_cost'  => ['health' => -5, 'vipers' => 5, 'score' => 10],
                'ai_preview' => 'Costs 5 HP. Vipers trust +5.',
            ],
            [
                'id'         => 'c01b',
                'text'       => 'Shadow the hooded figure first',
                'next'       => 'node_03',
                'requires'   => ['strength' => 20],
                'stat_cost'  => ['score' => 15, 'watch' => 5],
                'ai_preview' => 'No HP cost. Watch trust +5. Reveals extra info.',
            ],
            [
                'id'         => 'c01c',
                'text'       => 'Report the note to the City Watch',
                'next'       => 'node_04',
                'requires'   => [],
                'stat_cost'  => ['watch' => 15, 'vipers' => -20, 'score' => 5],
                'ai_preview' => 'Watch trust +15. Vipers will remember this.',
            ],
        ],
    ],

    'node_02' => [
        'id'   => 'node_02',
        'text' => 'The Crow\'s Tavern reeks of pipe smoke and old debts. The hooded figure — a Vipers informant named Sable — slides a folder across the table. "Taddle on the Guild master and we pay handsomely. Or don\'t, and we make your life difficult."',
        'choices' => [
            [
                'id'         => 'c02a',
                'text'       => 'Accept the job — gather intel on the Guild master',
                'next'       => 'node_05',
                'requires'   => [],
                'stat_cost'  => ['vipers' => 10, 'guild' => -10, 'score' => 15],
                'ai_preview' => 'Vipers +10, Guild -10. Opens high-reward path.',
            ],
            [
                'id'         => 'c02b',
                'text'       => 'Refuse and walk out',
                'next'       => 'node_06',
                'requires'   => [],
                'stat_cost'  => ['vipers' => -15, 'score' => 5],
                'ai_preview' => 'Vipers trust -15. Closes Viper ending.',
            ],
            [
                'id'         => 'c02c',
                'text'       => 'Use your Mage abilities to read Sable\'s true intentions',
                'next'       => 'node_05',
                'requires'   => ['class' => 'mage'],
                'stat_cost'  => ['mana' => -15, 'score' => 20, 'vipers' => 5],
                'ai_preview' => 'Mage only. Costs 15 mana. Reveals Sable\'s secret.',
            ],
        ],
    ],

    'node_03' => [
        'id'   => 'node_03',
        'text' => 'You tail Sable through three alleys and discover the handoff point for stolen Guild documents. You now hold leverage over both factions.',
        'choices' => [
            [
                'id'         => 'c03a',
                'text'       => 'Keep the documents as leverage',
                'next'       => 'node_05',
                'requires'   => [],
                'stat_cost'  => ['score' => 20, 'item' => 'guild_documents'],
                'ai_preview' => 'Adds Guild Documents — unlocks the Secret ending.',
            ],
            [
                'id'         => 'c03b',
                'text'       => 'Return the satchel to the Guild anonymously',
                'next'       => 'node_06',
                'requires'   => [],
                'stat_cost'  => ['guild' => 20, 'score' => 10],
                'ai_preview' => 'Guild trust +20. Strong ally formed.',
            ],
        ],
    ],

    'node_04' => [
        'id'   => 'node_04',
        'text' => 'Captain Aldric of the Watch thanks you formally and hands you a copper badge. "We\'ll be watching the Vipers. Stay close."',
        'choices' => [
            [
                'id'         => 'c04a',
                'text'       => 'Accept the badge and become a Watch informant',
                'next'       => 'node_06',
                'requires'   => [],
                'stat_cost'  => ['watch' => 20, 'vipers' => -10, 'score' => 15, 'item' => 'watch_badge'],
                'ai_preview' => 'Watch trust +20. Watch Badge added. Vipers -10.',
            ],
            [
                'id'         => 'c04b',
                'text'       => 'Decline the badge — stay unaffiliated',
                'next'       => 'node_06',
                'requires'   => [],
                'stat_cost'  => ['score' => 5],
                'ai_preview' => 'No faction alignment. Keeps options open.',
            ],
        ],
    ],

    'node_05' => [
        'id'   => 'node_05',
        'text' => 'Word spreads fast. The Guild master — a sharp woman named Veyne — has summoned you. She knows you\'ve been poking around.',
        'choices' => [
            [
                'id'         => 'c05a',
                'text'       => 'Come clean and offer to be a double agent',
                'next'       => 'node_07',
                'requires'   => [],
                'stat_cost'  => ['guild' => 15, 'vipers' => -10, 'health' => -10, 'score' => 20],
                'ai_preview' => 'Costs 10 HP and Viper trust. Guild +15 if she believes you.',
            ],
            [
                'id'         => 'c05b',
                'text'       => 'Bluff your way through the meeting',
                'next'       => 'node_07',
                'requires'   => ['strength' => 30],
                'stat_cost'  => ['score' => 25, 'guild' => 5],
                'ai_preview' => 'Requires 30 STR. Guild trust +5, score +25.',
            ],
            [
                'id'         => 'c05c',
                'text'       => 'Show Veyne the Guild Documents you recovered',
                'next'       => 'node_08',
                'requires'   => ['item' => 'guild_documents'],
                'stat_cost'  => ['guild' => 30, 'score' => 35],
                'ai_preview' => 'Requires Guild Documents. Guild trust +30.',
            ],
        ],
    ],

    'node_06' => [
        'id'   => 'node_06',
        'text' => 'Rumours of a grand "Reckoning" — a planned exposure of all three faction leaders — reach your ears from a street informant named Pip.',
        'choices' => [
            [
                'id'         => 'c06a',
                'text'       => 'Investigate the Reckoning',
                'next'       => 'node_07',
                'requires'   => [],
                'stat_cost'  => ['health' => -5, 'score' => 15],
                'ai_preview' => 'Costs 5 HP. Advances the main plot.',
            ],
            [
                'id'         => 'c06b',
                'text'       => 'Warn your strongest faction ally',
                'next'       => 'node_07',
                'requires'   => [],
                'stat_cost'  => ['score' => 10],
                'ai_preview' => 'Safe option. Boosts dominant faction trust.',
            ],
        ],
    ],

    'node_07' => [
        'id'   => 'node_07',
        'text' => 'The Reckoning is tomorrow. You have one chance to decide who survives — and who gets exposed.',
        'choices' => [
            [
                'id'         => 'c07a',
                'text'       => 'Side with the Vipers — expose the Guild and Watch',
                'next'       => 'node_09',
                'requires'   => ['vipers' => 40],
                'stat_cost'  => ['vipers' => 20, 'guild' => -30, 'watch' => -30, 'score' => 30],
                'ai_preview' => 'Requires 40 Viper trust. Viper ending path.',
            ],
            [
                'id'         => 'c07b',
                'text'       => 'Side with the Guild — expose the Vipers',
                'next'       => 'node_10',
                'requires'   => ['guild' => 40],
                'stat_cost'  => ['guild' => 20, 'vipers' => -30, 'score' => 30],
                'ai_preview' => 'Requires 40 Guild trust. Guild ending path.',
            ],
            [
                'id'         => 'c07c',
                'text'       => 'Play all three — expose everyone and disappear',
                'next'       => 'node_11',
                'requires'   => ['item' => 'guild_documents'],
                'stat_cost'  => ['score' => 50, 'health' => -20],
                'ai_preview' => 'Requires Guild Documents. Costs 20 HP. Secret ending.',
            ],
            [
                'id'         => 'c07d',
                'text'       => 'Alert the Watch — let the law handle it',
                'next'       => 'node_12',
                'requires'   => ['watch' => 40],
                'stat_cost'  => ['watch' => 20, 'score' => 25],
                'ai_preview' => 'Requires 40 Watch trust. Heroic ending via law.',
            ],
        ],
    ],

    'node_08' => [
        'id'   => 'node_08',
        'text' => 'Veyne studies the documents in silence. Then she smiles — a rare thing. "You\'ve just become the most valuable person in this city." She hands you a sealed envelope bearing the Guild crest.',
        'choices' => [
            [
                'id'         => 'c08a',
                'text'       => 'Open the envelope immediately',
                'next'       => 'node_07',
                'requires'   => [],
                'stat_cost'  => ['score' => 20, 'item' => 'guild_seal'],
                'ai_preview' => 'Adds Guild Seal — powerful item for Act 3.',
            ],
        ],
    ],

    'node_09' => [
        'id'      => 'node_09',
        'text'    => 'The Reckoning erupts. The Guild and Watch crumble under the Vipers\' coordinated strike. You stand at Sable\'s side as the smoke clears. The city is theirs — and yours.',
        'terminal'=> true,
        'ending'  => 'Heroic Victory',
        'choices' => [],
    ],

    'node_10' => [
        'id'      => 'node_10',
        'text'    => 'The Vipers are dismantled. Veyne and the Guild ascend, with you credited as the key informant. Your name is legend in certain circles — and a curse in others.',
        'terminal'=> true,
        'ending'  => 'Neutral Victory',
        'choices' => [],
    ],

    'node_11' => [
        'id'      => 'node_11',
        'text'    => 'All three factions implode simultaneously. In the chaos you slip away with enough secrets to disappear entirely. Nobody even knows your real name.',
        'terminal'=> true,
        'ending'  => 'Secret Path',
        'choices' => [],
    ],

    'node_12' => [
        'id'      => 'node_12',
        'text'    => 'Captain Aldric\'s Watch sweeps the city. Every faction leader faces justice. You testify under oath and walk out a free citizen.',
        'terminal'=> true,
        'ending'  => 'Heroic Victory',
        'choices' => [],
    ],

    'node_tragic' => [
        'id'      => 'node_tragic',
        'text'    => 'Your wounds catch up with you in a damp alley. The city carries on without you.',
        'terminal'=> true,
        'ending'  => 'Tragic Failure',
        'choices' => [],
    ],

];