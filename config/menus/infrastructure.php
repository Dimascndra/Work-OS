<?php

return [
    [
        'title' => 'Servers',
        'icon' => 'Devices/Server',
        'route' => '/servers',
    ],
    [
        'title' => 'Domain Monitors',
        'icon' => 'Code/Git2', // Represents branching/network or Code/Time-schedule for monitoring. Let's use Code/Git2 as a placeholder for network/nodes or Code/Terminal for monitors
        // Actually 'Code/Warning-2.svg' might be good for status, but let's go with 'Devices/Router2' if available or 'Code/Git2' which looks like nodes.
        // Let's check list again... 'Code/Time-schedule' sounds like periodic monitoring.
        'icon' => 'Code/Time-schedule',
        'route' => '/domain-monitors',
    ],
    [
        'title' => 'Backups',
        'icon' => 'Files/Cloud-upload',
        'route' => '/server-backups',
    ],
];
