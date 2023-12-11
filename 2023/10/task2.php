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

replaceS();

for ($x = 0; $x < count($map); $x++) {
    for ($y = 0; $y < count($map[$x]); $y++) {
        $map[$x][$y] = in_array([$x, $y], $path) ? $map[$x][$y] : ' ';
    }
}

$sum = 0;

for ($y = count($map[0]) - 1; $y >= 0; $y--) {
    $rowTilesCount = 0;

    for ($x = 0; $x < count($map); $x++) {
        if ($map[$x][$y] !== ' ') {
            continue;
        }

        $crossings = 0;
        $lastOpeningChar = '';

        for ($i = 0; $i < $x; $i++) {
            $char = $map[$i][$y];

            if ($char === '|') {
                $crossings++;
            }

            if (in_array($char, ['F', 'L'])) {
                $lastOpeningChar = $char;
            }

            if ($lastOpeningChar === 'L' && $char === '7') {
                $crossings++;
            }

            if ($lastOpeningChar === 'F' && $char === 'J') {
                $crossings++;
            }
        }

        if ($crossings % 2 === 1) {
            $rowTilesCount++;
        }
    }

    $sum += $rowTilesCount;
}

var_dump($sum);

function replaceS()
{
    global $map, $path;
    [$x, $y] = $path[0];

    if (
        in_array([$x, $y + 1], $path) &&
        in_array($map[$x][$y + 1], ['|', '7', 'F']) &&
        in_array([$x, $y - 1], $path) &&
        in_array($map[$x][$y - 1], ['|', 'J', 'L'])
    ) {
        $map[$x][$y] = '|';
    }
    if (
        in_array([$x + 1, $y], $path) &&
        in_array($map[$x + 1][$y], ['-', 'J', '7']) &&
        in_array([$x - 1, $y], $path) &&
        in_array($map[$x - 1][$y], ['-', 'F', 'L'])
    ) {
        $map[$x][$y] = '-';
    }
    if (
        in_array([$x + 1, $y], $path) &&
        in_array($map[$x + 1][$y], ['-', 'J', '7']) &&
        in_array([$x, $y - 1], $path) &&
        in_array($map[$x][$y - 1], ['|', 'J', 'L'])
    ) {
        $map[$x][$y] = 'F';
    }
    if (
        in_array([$x - 1, $y], $path) &&
        in_array($map[$x - 1][$y], ['-', 'F', 'L']) &&
        in_array([$x, $y - 1], $path) &&
        in_array($map[$x][$y - 1], ['|', 'J', 'L'])
    ) {
        $map[$x][$y] = '7';
    }
    if (
        in_array([$x, $y + 1], $path) &&
        in_array($map[$x][$y + 1], ['|', '7', 'F']) &&
        in_array([$x - 1, $y], $path) &&
        in_array($map[$x - 1][$y], ['-', 'F', 'L'])
    ) {
        $map[$x][$y] = 'J';
    }
    if (
        in_array([$x, $y + 1], $path) &&
        in_array($map[$x][$y + 1], ['|', '7', 'F']) &&
        in_array([$x + 1, $y], $path) &&
        in_array($map[$x + 1][$y], ['-', 'J', '7'])
    ) {
        $map[$x][$y] = 'L';
    }
}

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
