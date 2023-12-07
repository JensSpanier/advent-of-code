<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

$hands = [];

foreach ($lines as $line) {
    [$hand, $bid] = explode(' ', $line);
    $hands[] = [
        $hand,
        (int) $bid,
        getValueOfHand($hand),
    ];
}

usort($hands, 'compare');

$result = 0;

foreach ($hands as $index => $hand) {
    [, $bid] = $hand;
    $result += $bid * ($index + 1);
}

var_dump($result);


function compare($a, $b)
{
    [$handA] = $a;
    [$handB] = $b;

    $valueA = getValueOfHand($handA);
    $valueB = getValueOfHand($handB);

    if ($valueA === $valueB) {
        return compareChars($handA, $handB);
    }

    return ($valueA < $valueB) ? -1 : 1;
}

function compareChars($handA, $handB)
{
    $order = ['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'];

    for ($i = 0; $i < 5; $i++) {
        $valueA = array_search($handA[$i], $order);
        $valueB = array_search($handB[$i], $order);

        if ($valueA === $valueB) {
            continue;
        }

        return ($valueA > $valueB) ? -1 : 1;
    }
}

function getValueOfHand($hand)
{
    $countedChars = count_chars($hand, 1);
    sort($countedChars);

    if ($countedChars === [5]) {
        return 7;
    }
    if ($countedChars === [1, 4]) {
        return 6;
    }
    if ($countedChars === [2, 3]) {
        return 5;
    }
    if ($countedChars === [1, 1, 3]) {
        return 4;
    }
    if ($countedChars === [1, 2, 2]) {
        return 3;
    }
    if ($countedChars === [1, 1, 1, 2]) {
        return 2;
    }
    if ($countedChars === [1, 1, 1, 1, 1]) {
        return 1;
    }
}
