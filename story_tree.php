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
        'text' => 'Veyne studies the documents in silence for a long moment. Then, slowly, she smiles — a rare thing on that careful face. "You have just made yourself the most valuable person in this city." She slides a sealed envelope across the table, Guild crest pressed into wax.',
        'choices' => [
            [
                'id'         => 'c08a',
                'text'       => 'Open it immediately',
                'next'       => 'node_13',
                'requires'   => [],
                'stat_cost'  => ['score' => 20, 'item' => 'guild_seal'],
                'ai_preview' => 'Adds Guild Seal — unlocks a hidden path in Act 3.',
            ],
            [
                'id'         => 'c08b',
                'text'       => 'Pocket it unopened and leave',
                'next'       => 'node_07',
                'requires'   => [],
                'stat_cost'  => ['score' => 10, 'guild' => 5],
                'ai_preview' => 'Keeps options open. Guild trust +5.',
            ],
        ],
    ],

    'node_13' => [
        'id'   => 'node_13',
        'text' => 'Inside: a map of the Vipers\' underground network, annotated in a hand you recognise as Sable\'s. Someone inside the Vipers has been feeding information to the Guild for months. Sable is a double agent — and she doesn\'t know you know.',
        'choices' => [
            [
                'id'         => 'c13a',
                'text'       => 'Confront Sable directly',
                'next'       => 'node_14',
                'requires'   => ['strength' => 30],
                'stat_cost'  => ['health' => -10, 'vipers' => -15, 'guild' => 10, 'score' => 20],
                'ai_preview' => 'Requires 30 STR. Risky — costs 10 HP, Vipers -15.',
            ],
            [
                'id'         => 'c13b',
                'text'       => 'Use the map to blackmail both sides',
                'next'       => 'node_15',
                'requires'   => [],
                'stat_cost'  => ['vipers' => 10, 'guild' => 10, 'score' => 30],
                'ai_preview' => 'Both factions +10 trust. High-risk, high-reward.',
            ],
            [
                'id'         => 'c13c',
                'text'       => 'Hand the map to Captain Aldric',
                'next'       => 'node_16',
                'requires'   => ['item' => 'watch_badge'],
                'stat_cost'  => ['watch' => 25, 'score' => 25],
                'ai_preview' => 'Requires Watch Badge. Watch trust +25.',
            ],
        ],
    ],

    'node_14' => [
        'id'   => 'node_14',
        'text' => 'Sable doesn\'t flinch. "So you figured it out." She leans back, arms crossed. "Question is what you do with it. The Vipers will burn this city if the Reckoning fails. The Guild needs that map back — and so do you." She offers her hand.',
        'choices' => [
            [
                'id'         => 'c14a',
                'text'       => 'Take her hand — unlikely allies',
                'next'       => 'node_07',
                'requires'   => [],
                'stat_cost'  => ['vipers' => 15, 'guild' => 15, 'score' => 25],
                'ai_preview' => 'Both factions +15. Strong position heading into Act 3.',
            ],
            [
                'id'         => 'c14b',
                'text'       => 'Walk away — trust no one',
                'next'       => 'node_07',
                'requires'   => [],
                'stat_cost'  => ['score' => 10],
                'ai_preview' => 'No faction cost. Keeps independence but weakens alliances.',
            ],
        ],
    ],

    'node_15' => [
        'id'   => 'node_15',
        'text' => 'The blackmail works — for now. Both factions pay. Both factions seethe. You have money, leverage, and a very short window before one of them decides you\'re more dangerous alive than dead. Pip finds you in the market. "The Reckoning\'s been moved up. Tomorrow at dawn."',
        'choices' => [
            [
                'id'         => 'c15a',
                'text'       => 'Use your leverage to broker a truce before dawn',
                'next'       => 'node_07',
                'requires'   => ['strength' => 25],
                'stat_cost'  => ['score' => 35, 'health' => -5],
                'ai_preview' => 'Requires 25 STR. Best score outcome. Costs 5 HP.',
            ],
            [
                'id'         => 'c15b',
                'text'       => 'Disappear before it starts',
                'next'       => 'node_07',
                'requires'   => [],
                'stat_cost'  => ['score' => 15],
                'ai_preview' => 'Safe exit. Lower score but no risk.',
            ],
        ],
    ],

    'node_16' => [
        'id'   => 'node_16',
        'text' => 'Aldric studies the map for a long time. "This changes everything." He rolls it carefully and locks it in a strongbox. "We move at first light. I need someone inside the Vipers\' meeting hall at the third bell. Someone they won\'t recognise." He looks at you.',
        'choices' => [
            [
                'id'         => 'c16a',
                'text'       => 'Accept — go in as a Vipers contact',
                'next'       => 'node_17',
                'requires'   => [],
                'stat_cost'  => ['watch' => 10, 'health' => -10, 'score' => 30],
                'ai_preview' => 'High risk. Watch trust +10, costs 10 HP.',
            ],
            [
                'id'         => 'c16b',
                'text'       => 'Decline — provide the Watch with everything you know instead',
                'next'       => 'node_07',
                'requires'   => [],
                'stat_cost'  => ['watch' => 20, 'score' => 20],
                'ai_preview' => 'Safer. Watch trust +20.',
            ],
        ],
    ],

    'node_17' => [
        'id'   => 'node_17',
        'text' => 'The Vipers\' hall smells of tallow and damp stone. You are three minutes into listening to the Reckoning\'s final plan when a hand lands on your shoulder. It is Sable. She leans close. "I knew you\'d come. I left the back door open for a reason." She slips you a key.',
        'choices' => [
            [
                'id'         => 'c17a',
                'text'       => 'Take the key and slip out the back',
                'next'       => 'node_07',
                'requires'   => [],
                'stat_cost'  => ['score' => 25, 'vipers' => 10],
                'ai_preview' => 'Clean exit. Vipers trust +10.',
            ],
            [
                'id'         => 'c17b',
                'text'       => 'Stay and memorise everything — then signal the Watch',
                'next'       => 'node_07',
                'requires'   => ['watch' => 50],
                'stat_cost'  => ['watch' => 20, 'score' => 40, 'health' => -15],
                'ai_preview' => 'Requires 50 Watch trust. Best Watch path score. Costs 15 HP.',
            ],
        ],
    ],

    'node_09' => [
        'id'      => 'node_09',
        'text'    => 'The Reckoning ignites the lower city at midnight. Fire and fracture. By the time the smoke clears, the Guild and Watch are broken, their leaders in exile or chains. Sable raises a glass across the smouldering rubble. The city belongs to the Vipers now — and you are one of them.',
        'terminal'=> true,
        'ending'  => 'Heroic Victory',
        'choices' => [],
    ],

    'node_10' => [
        'id'      => 'node_10',
        'text'    => 'The Vipers splinter overnight, undone by the very documents you delivered. Veyne steps into the vacuum with quiet authority, the Guild ascending as the city\'s new order. She names you a consultant — the word is a polite fiction for something far more dangerous and far better paid.',
        'terminal'=> true,
        'ending'  => 'Neutral Victory',
        'choices' => [],
    ],

    'node_11' => [
        'id'      => 'node_11',
        'text'    => 'All three faction leaders receive the same package at dawn: everything, on everyone. The city erupts. In the chaos you walk to the south gate with a single bag and do not look back. Three organisations are hunting you. None of them know your name. That was always the point.',
        'terminal'=> true,
        'ending'  => 'Secret Path',
        'choices' => [],
    ],

    'node_12' => [
        'id'      => 'node_12',
        'text'    => 'Aldric\'s Watch moves at first light, precise and coordinated, every faction head arrested before breakfast. You testify before a magistrate at noon. By evening, the city is quieter than it has been in years. You step outside the courthouse into clean air and walk east, a free citizen with a clear name.',
        'terminal'=> true,
        'ending'  => 'Heroic Victory',
        'choices' => [],
    ],

    'node_tragic' => [
        'id'      => 'node_tragic',
        'text'    => 'The city finds you before you find your footing. A narrow alley, a wound that will not close, a morning that does not come. Somewhere above the rooftops, the factions carry on their business without you. They always do.',
        'terminal'=> true,
        'ending'  => 'Tragic Failure',
        'choices' => [],
    ],

];