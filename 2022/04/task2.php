<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = trim($input);

$lines = preg_split("/\r\n|\n|\r/", $input);

$total = 0;

foreach ($lines as $line) {
    [$elf1, $elf2] = explode(',', $line);
    [$elf1start, $elf1end] = explode('-', $elf1);
    [$elf2start, $elf2end] = explode('-', $elf2);
    $range1 = range($elf1start, $elf1end);
    $range2 = range($elf2start, $elf2end);
    $same = array_intersect($range1, $range2);
    if (count($same) > 0)
        $total++;
}

echo $total;
