<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

$games = [];

foreach ($lines as $line) {
    [$game, $results] = explode(':', $line);
    [, $gameId] = explode(' ', $game);

    $subsets = explode(';', $results);

    $subsetResults = [];

    foreach ($subsets as $subset) {
        $reveals = explode(',', $subset);

        $revealResult = [];

        foreach ($reveals as $reveal) {
            [$count, $color] = explode(' ', trim($reveal));
            $revealResult[$color] = (int) $count;
        }

        $subsetResults[] = $revealResult;
    }

    $games[$gameId] = $subsetResults;
}

$possibleGamesSum = 0;

foreach ($games as $gameId => $reveals) {
    $red = 0;
    $green = 0;
    $blue = 0;

    foreach ($reveals as $reveal) {
        if (
            ($reveal['red'] ?? 0) > $red
        ) {
            $red = $reveal['red'];
        }
        if (
            ($reveal['green'] ?? 0) > $green
        ) {
            $green = $reveal['green'];
        }
        if (
            ($reveal['blue'] ?? 0) > $blue
        ) {
            $blue = $reveal['blue'];
        }
    }

    $possibleGamesSum += $red * $green * $blue;
}

var_dump($possibleGamesSum);
