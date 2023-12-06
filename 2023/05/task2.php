<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

$result = 0;

$seeds = [];
$maps = [];

$currentMap = '';

foreach ($lines as $line) {
    if (str_starts_with($line, 'seeds:')) {
        [, $rawSeeds] = explode(':', $line);
        $splittedSeeds = arrayToInt(explode(' ', trim($rawSeeds)));
        while (count($splittedSeeds) > 0) {
            $seeds[] = [
                array_shift($splittedSeeds),
                array_shift($splittedSeeds),
            ];
        }
        continue;
    }

    if (str_contains($line, 'map:')) {
        [$currentMap] = explode(' ', $line);
        continue;
    }

    if ($line === '') {
        continue;
    }

    $maps[$currentMap][] = arrayToInt(explode(' ', $line));
}

$locationCounter = 0;

while (true) {
    $locationCounter++;

    echo "\r" . number_format($locationCounter, 0, ',', '.');

    $humidity = getSource('humidity-to-location', $locationCounter);
    $temperature = getSource('temperature-to-humidity', $humidity);
    $light = getSource('light-to-temperature', $temperature);
    $water = getSource('water-to-light', $light);
    $fertilizer = getSource('fertilizer-to-water', $water);
    $soil = getSource('soil-to-fertilizer', $fertilizer);
    $seed = getSource('seed-to-soil', $soil);

    foreach ($seeds as $seedRange) {
        [$start, $length] = $seedRange;

        if (
            $seed >= $start &&
            $seed < $start + $length
        ) {
            echo PHP_EOL . 'Location: ' . number_format($locationCounter, 0, ',', '.') . PHP_EOL;
            echo  'Seed: ' . number_format($seed, 0, ',', '.') . PHP_EOL;
            exit;
        }
    }
}

function arrayToInt($input)
{
    $result = [];

    foreach ($input as $item) {
        $result[] = (int) $item;
    }

    return $result;
}

function getSource($mapName, $destination)
{
    global $maps;
    $map = $maps[$mapName];

    foreach ($map as $mapItem) {
        [
            $destinationRangeStart,
            $sourceRangeStart,
            $rangeLength,
        ] = $mapItem;

        if (
            $destination >= $destinationRangeStart &&
            $destination < $destinationRangeStart + $rangeLength
        ) {
            $diff = $destination - $destinationRangeStart;
            return $sourceRangeStart + $diff;
        }
    }

    return $destination;
}
