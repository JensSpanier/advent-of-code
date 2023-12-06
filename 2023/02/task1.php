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
    foreach ($reveals as $reveal) {
        if (
            ($reveal['red'] ?? 0) > 12 ||
            ($reveal['green'] ?? 0) > 13 ||
            ($reveal['blue'] ?? 0) > 14
        ) {
            continue 2;
        }
    }
    $possibleGamesSum += $gameId;
}

var_dump($possibleGamesSum);
