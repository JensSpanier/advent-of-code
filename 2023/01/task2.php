<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');

$total = 0;

$numbers = [
    1 => 1,
    2 => 2,
    3 => 3,
    4 => 4,
    5 => 5,
    6 => 6,
    7 => 7,
    8 => 8,
    9 => 9,
    'one' => 1,
    'two' => 2,
    'three' => 3,
    'four' => 4,
    'five' => 5,
    'six' => 6,
    'seven' => 7,
    'eight' => 8,
    'nine' => 9,
];

foreach ($lines as $line) {
    $total += getFirstNumber($line) . getLastNumber($line) . PHP_EOL;
}



function getFirstNumber(string $line): string
{
    global $numbers;
    for ($i = 0; $i < strlen($line); $i++) {
        $haystack = substr($line, 0, $i + 1);
        foreach ($numbers as $needle => $value) {
            if (str_contains($haystack, $needle)) {
                return $value;
            }
        }
    }

    throw new Exception('No number found');
}

function getLastNumber(string $line): string
{
    global $numbers;
    for ($i = 0; $i < strlen($line); $i++) {
        $haystack = substr($line, - ($i + 1));
        foreach ($numbers as $needle => $value) {
            if (str_contains($haystack, $needle)) {
                return $value;
            }
        }
    }

    throw new Exception('No number found');
}

var_dump($total);
