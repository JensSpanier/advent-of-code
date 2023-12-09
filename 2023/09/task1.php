<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

$histories = [];

foreach ($lines as $line) {
    $histories[] = [explode(' ', $line)];
}

for ($i = 0; $i < count($histories); $i++) {
    while (true) {
        $lastDataset = $histories[$i][array_key_last($histories[$i])];

        $newDataset = [];
        for ($j = 1; $j < count($lastDataset); $j++) {
            $newDataset[] = $lastDataset[$j] - $lastDataset[$j - 1];
        }
        $histories[$i][] = $newDataset;
        if (!array_diff($newDataset, [0])) {
            break;
        }
    }
}


for ($i = 0; $i < count($histories); $i++) {
    $countDatasets = count($histories[$i]);
    for ($j = $countDatasets - 1; $j >= 0; $j--) {
        if ($j === $countDatasets - 1) {
            $histories[$i][$j][] = 0;
            continue;
        }

        $histories[$i][$j][] =
            $histories[$i][$j + 1][array_key_last($histories[$i][$j + 1])] +
            $histories[$i][$j][array_key_last($histories[$i][$j])];
    }
}

$result = 0;

foreach ($histories as $datasets) {
    $result += $datasets[0][array_key_last($datasets[0])];
}

echo $result;
