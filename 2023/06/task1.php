<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

[, $rawTimes] = explode(':', $lines[0]);
[, $rawDistances] = explode(':', $lines[1]);
$times = array_values(array_filter(explode(' ', $rawTimes), 'notEmpty'));
$distances = array_values(array_filter(explode(' ', $rawDistances), 'notEmpty'));

$races = [];

for ($i = 0; $i < count($times); $i++) {
    $races[] = [
        (int) $times[$i],
        (int) $distances[$i],
    ];
}

$result = 1;

foreach ($races as $race) {
    [$totalTime, $recordDistance] = $race;

    $ways = 0;

    for ($time = 1; $time < $totalTime; $time++) {
        $distance = $time * ($totalTime - $time);
        if ($distance > $recordDistance) {
            $ways++;
        }
    }

    $result *= $ways;
}

echo $result . PHP_EOL;

function notEmpty($var)
{
    return !empty($var);
}
