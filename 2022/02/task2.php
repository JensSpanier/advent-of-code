<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = trim($input);

$lines = preg_split("/\r\n|\n|\r/", $input);

$totalPoints = 0;
foreach ($lines as $line) {
    [$opponentChoise, $neededResult] = explode(' ', $line);
    $opponentChoise = getOpponentChoiseByLetter($opponentChoise);
    $ownChoise = getOwnChoiseByLetter($opponentChoise, $neededResult);
    $points = getPoints($opponentChoise, $ownChoise);
    echo "$opponentChoise vs. $ownChoise: $points"  . PHP_EOL;
    $totalPoints += $points;
}
echo "Total points: $totalPoints";

function getOpponentChoiseByLetter(string $letter): string
{
    switch ($letter) {
        case 'A':
            return 'Rock';
        case 'B':
            return 'Paper';
        case 'C':
            return 'Scissors';
    }
}

function getOwnChoiseByLetter(string $opponentChoise, string $neededResult): string
{
    if ($neededResult === 'Y')
        return $opponentChoise;
    if ($opponentChoise === 'Rock')
        return $neededResult === 'Z' ? 'Paper' : 'Scissors';
    if ($opponentChoise === 'Paper')
        return $neededResult === 'Z' ? 'Scissors' : 'Rock';
    if ($opponentChoise === 'Scissors')
        return $neededResult === 'Z' ? 'Rock' : 'Paper';
}

function getPoints(string $opponentChoise, string $ownChoise): int
{
    return getPointsForOwnChoise($ownChoise) + getPointsForBattle($opponentChoise, $ownChoise);
}

function getPointsForBattle(string $opponentChoise, string $ownChoise): int
{
    if ($opponentChoise === $ownChoise)
        return 3;
    if ($opponentChoise === 'Rock' && $ownChoise === 'Paper')
        return 6;
    if ($opponentChoise === 'Paper' && $ownChoise === 'Scissors')
        return 6;
    if ($opponentChoise === 'Scissors' && $ownChoise === 'Rock')
        return 6;
    return 0;
}

function getPointsForOwnChoise(string $ownChoise): int
{
    switch ($ownChoise) {
        case 'Rock':
            return 1;
        case 'Paper':
            return 2;
        case 'Scissors':
            return 3;
    }
}
