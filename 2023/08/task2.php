<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

$nodes = [];
$nodesEndingWithA = [];

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

    if ($line[2] === 'A') {
        $nodesEndingWithA[] = substr($line, 0, 3);
    }
}

$currentNodes = $nodesEndingWithA;
$totalDirections = count($directions);
$steps = [];

foreach ($currentNodes as $currentNodeIndex => $currentNode) {
    $stepCounter = 0;
    while (true) {
        $direction = $directions[$stepCounter % $totalDirections];
        $oldNode = $currentNodes[$currentNodeIndex];
        $currentNodes[$currentNodeIndex] = $nodes[$oldNode][$direction === 'L' ? 0 : 1];
        $stepCounter++;
        if ($currentNodes[$currentNodeIndex][2] === 'Z') {
            $steps[] = $stepCounter;
            break;
        }
    }
}

$result = 1;

foreach ($steps as $step) {
    $lcm = gmp_lcm($result, $step);
    $result = gmp_intval($lcm);
}

echo $result . PHP_EOL;
