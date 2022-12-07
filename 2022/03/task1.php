<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = trim($input);

$lines = preg_split("/\r\n|\n|\r/", $input);

$rucksacks = [];

foreach ($lines as $line) {
    $chars = str_split($line);
    $middle = strlen($line) / 2;
    $rucksacks[] = array_chunk($chars, $middle);
}

$total = 0;

foreach ($rucksacks as $rucksack) {
    $doubleItemTypes = array_intersect($rucksack[0], $rucksack[1]);
    $doubleItemType = $doubleItemTypes[array_key_first($doubleItemTypes)];
    $total += getPriorityByChar($doubleItemType);
}
echo $total;

function getPriorityByChar(string $char)
{
    $lower = range('a', 'z');
    $upper = range('A', 'Z');
    $lowerFound = array_search($char, $lower);
    $upperFound = array_search($char, $upper);
    if ($lowerFound !== false)
        return $lowerFound + 1;
    if ($upperFound !== false)
        return $upperFound + 27;
}
