<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

$total = 0;

foreach ($lines as $line) {
    $chars = str_split($line);
    $reversedChars = array_reverse($chars);

    $total += getFirstNumber($chars) . getFirstNumber($reversedChars);
}

function getFirstNumber(array $chars): string
{
    foreach ($chars as $char) {
        if (ctype_digit($char)) {
            return $char;
        }
    }

    throw new Exception('No number found');
}

var_dump($total);
