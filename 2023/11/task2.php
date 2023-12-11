<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

$map = [];
$emptyRows = [];
$emptyColumns = [];

foreach ($lines as $y => $line) {
    $splittedLine = str_split($line);
    $galaxiesCount = 0;
    foreach ($splittedLine as $x => $char) {
        if ($char === '#') {
            $galaxiesCount++;
        }
        $map[$y][$x] = $char;
    }

    if ($galaxiesCount === 0) {
        $emptyRows[] = $y;
    }
}

for ($x = 0; $x < count($map[0]); $x++) {
    $galaxiesCount = 0;
    for ($y = 0; $y < count($map); $y++) {
        if ($map[$y][$x] === '#') {
            $galaxiesCount++;
        }
    }

    if ($galaxiesCount === 0) {
        $emptyColumns[] = $x;
    }
}

$emptyRows = array_reverse($emptyRows);
$emptyColumns = array_reverse($emptyColumns);

$galaxyPositions = [];

for ($y = 0; $y < count($map); $y++) {
    for ($x = 0; $x < count($map[0]); $x++) {
        if ($map[$y][$x] === '#') {
            $galaxyPositions[] = [$x, $y];
        }
    }
}

$sum = 0;

for ($i = 0; $i < count($galaxyPositions); $i++) {
    [$xStart, $yStart] = $galaxyPositions[$i];

    for ($j = $i + 1; $j < count($galaxyPositions); $j++) {
        [$xEnd, $yEnd] = $galaxyPositions[$j];

        $horizontal = abs($xStart - $xEnd);
        $vertical = abs($yStart - $yEnd);

        $passedRows = array_keys(array_fill(min($yStart, $yEnd), $vertical, ''));
        $passedColumns = array_keys(array_fill(min($xStart, $xEnd), $horizontal, ''));

        $amountPassedEmptyRows = count(array_intersect($emptyRows, $passedRows));
        $amountPassedEmptyColumns = count(array_intersect($emptyColumns, $passedColumns));

        $sum += $horizontal + $vertical + ($amountPassedEmptyRows + $amountPassedEmptyColumns) * (1_000_000 - 1);
    }
}

var_dump($sum);
