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
        $seeds = arrayToInt(explode(' ', trim($rawSeeds)));
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

$locations = [];

foreach ($seeds as $seed) {
    $soil = getDestination('seed-to-soil', $seed);
    $fertilizer = getDestination('soil-to-fertilizer', $soil);
    $water = getDestination('fertilizer-to-water', $fertilizer);
    $light = getDestination('water-to-light', $water);
    $temperature = getDestination('light-to-temperature', $light);
    $humidity = getDestination('temperature-to-humidity', $temperature);
    $locations[] = getDestination('humidity-to-location', $humidity);
}

var_dump(min(...$locations));

function arrayToInt($input)
{
    $result = [];

    foreach ($input as $item) {
        $result[] = (int) $item;
    }

    return $result;
}

function getDestination($mapName, $source)
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
            $source >= $sourceRangeStart &&
            $source < $sourceRangeStart + $rangeLength
        ) {
            $diff = $source - $sourceRangeStart;
            return $destinationRangeStart + $diff;
        }
    }

    return $source;
}
