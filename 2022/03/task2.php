<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = trim($input);

$lines = preg_split("/\r\n|\n|\r/", $input);

$elfGroups = array_chunk($lines, 3);


$total = 0;
foreach ($elfGroups as $elfGroup) {
    $elf1 = $elfGroup[0];
    $elf2 = $elfGroup[1];
    $elf3 = $elfGroup[2];
    $chars1 = str_split($elf1);
    $chars2 = str_split($elf2);
    $chars3 = str_split($elf3);
    $doubleItemTypes = array_intersect($chars1, $chars2, $chars3);
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
