<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

[, $rawTimes] = explode(':', $lines[0]);
[, $rawDistances] = explode(':', $lines[1]);

$totalTime = (int) str_replace(' ', '', $rawTimes);
$recordDistance = (int) str_replace(' ', '', $rawDistances);

$ways = 0;

for ($time = 1; $time < $totalTime; $time++) {
    $distance = $time * ($totalTime - $time);
    if ($distance > $recordDistance) {
        $ways++;
    }
}

echo $ways . PHP_EOL;
