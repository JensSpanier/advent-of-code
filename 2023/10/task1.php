<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');
$lines = array_reverse($lines);

$map = [];

foreach ($lines as $y => $line) {
    $splittedLine = str_split($line);
    foreach ($splittedLine as $x => $char) {
        $map[$x][$y] = $char;
    }
}

$path = [findStartPosition()];
while (true) {
    $currentPosition = $path[array_key_last($path)];
    $nextPosition = getNextPosition($currentPosition);
    if (!in_array($nextPosition, $path)) {
        $path[] = $nextPosition;
    } else {
        break;
    }
}

echo count($path) / 2;

function getNextPosition($currentPosition)
{
    global $map, $path;

    [$x, $y] = $currentPosition;

    $currentSymbol = $map[$x][$y];

    if ($currentSymbol === '-') {
        return in_array([$x + 1, $y], $path) ? [$x - 1, $y] : [$x + 1, $y];
    }
    if ($currentSymbol === '|') {
        return in_array([$x, $y + 1], $path) ? [$x, $y - 1] : [$x, $y + 1];
    }
    if ($currentSymbol === 'F') {
        return in_array([$x, $y - 1], $path) ? [$x + 1, $y] : [$x, $y - 1];
    }
    if ($currentSymbol === '7') {
        return in_array([$x - 1, $y], $path) ? [$x, $y - 1] : [$x - 1, $y];
    }
    if ($currentSymbol === 'J') {
        return in_array([$x, $y + 1], $path) ? [$x - 1, $y] : [$x, $y + 1];
    }
    if ($currentSymbol === 'L') {
        return in_array([$x, $y + 1], $path) ? [$x + 1, $y] : [$x, $y + 1];
    }

    if ($currentSymbol === 'S') {
        // Check north
        if ($y + 1 < count($map[0]) && in_array($map[$x][$y + 1], ['|', '7', 'F'])) {
            return [$x, $y + 1];
        }
        // Check east
        if ($x + 1 < count($map) && in_array($map[$x + 1][$y], ['-', 'J', '7'])) {
            return [$x + 1, $y];
        }
        // Check south
        if ($y - 1 >= 0 && in_array($map[$x][$y - 1], ['|', 'J', 'L'])) {
            return [$x, $y - 1];
        }
        // Check west
        if ($x - 1 >= 0 && in_array($map[$x - 1][$y], ['-', 'F', 'L'])) {
            return [$x - 1, $y];
        }
    }
}

function findStartPosition()
{
    global $map;

    for ($x = 0; $x < count($map); $x++) {
        for ($y = 0; $y < count($map[0]); $y++) {
            if ($map[$x][$y] === 'S')
                return [$x, $y];
        }
    }
}
