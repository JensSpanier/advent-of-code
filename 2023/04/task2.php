<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

$cards = [];

foreach ($lines as $lineIndex => $line) {
    [, $rawNumbers] = explode(':', $line);
    [$rawWinningNumbers, $rawOwnNumbers] = explode('|', $rawNumbers);

    $splittedWinningNumbers = explode(' ', $rawWinningNumbers);
    $splittedOwnNumbers = explode(' ', $rawOwnNumbers);

    $winningNumbers = array_filter($splittedWinningNumbers, 'notEmpty');
    $ownNumbers = array_filter($splittedOwnNumbers, 'notEmpty');

    $intersection = array_intersect($winningNumbers, $ownNumbers);
    $intersectionAmount = count($intersection);

    $cards[] = [
        'cardNumber' => $lineIndex + 1,
        'matchingNumbers' => $intersectionAmount,
    ];
}

$result = count($cards);

for ($i = count($cards) - 1; $i >= 0; $i--) {
    $cards[$i]['additionalCopies'] = $cards[$i]['matchingNumbers'];
    for ($j = $i + 1; $j <= $i + $cards[$i]['matchingNumbers']; $j++) {
        $cards[$i]['additionalCopies'] += $cards[$j]['additionalCopies'];
    }
}

foreach ($cards as $card) {
    $result += $card['additionalCopies'];
}

var_dump($result);

function notEmpty($var)
{
    return !empty($var);
}
