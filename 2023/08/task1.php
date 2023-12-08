<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

$nodes = [];

foreach ($lines as $lineIndex => $line) {
    if ($lineIndex === 0) {
        $directions = str_split($line);
        continue;
    }

    if ($lineIndex === 1) {
        continue;
    }

    $nodes[substr($line, 0, 3)] = [
        substr($line, 7, 3),
        substr($line, 12, 3),
    ];
}

$startNode = 'AAA';
$endNode = 'ZZZ';

$currentNode = $nodes[$startNode];

$steps = 0;

while (true) {
    $direction = $directions[$steps % count($directions)];

    $nextNode = $currentNode[$direction === 'L' ? 0 : 1];
    $steps++;

    if ($nextNode === $endNode) {
        echo $steps . PHP_EOL;
        exit;
    }

    $currentNode = $nodes[$nextNode];
}
