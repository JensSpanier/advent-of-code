<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

$result = 0;

foreach ($lines as $line) {
    [, $rawNumbers] = explode(':', $line);
    [$rawWinningNumbers, $rawOwnNumbers] = explode('|', $rawNumbers);

    $splittedWinningNumbers = explode(' ', $rawWinningNumbers);
    $splittedOwnNumbers = explode(' ', $rawOwnNumbers);

    $winningNumbers = array_filter($splittedWinningNumbers, 'notEmpty');
    $ownNumbers = array_filter($splittedOwnNumbers, 'notEmpty');

    $intersection = array_intersect($winningNumbers, $ownNumbers);

    $intersectionAmount = count($intersection);

    if ($intersectionAmount > 0) {
        $worth = pow(2, $intersectionAmount - 1);
        $result += $worth;
    }
}

var_dump($result);

function notEmpty($var)
{
    return !empty($var);
}
