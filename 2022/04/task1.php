<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = trim($input);

$lines = preg_split("/\r\n|\n|\r/", $input);

$total = 0;

foreach ($lines as $line) {
    [$elf1, $elf2] = explode(',', $line);
    [$elf1start, $elf1end] = explode('-', $elf1);
    [$elf2start, $elf2end] = explode('-', $elf2);
    //$elf1start = (int) $elf1start;
    //$elf1end = (int) $elf1end;
    //$elf2start = (int) $elf2start;
    //$elf2end = (int) $elf2end;
    if (
        ($elf1start <= $elf2start && $elf1end >= $elf2end) ||
        ($elf2start <= $elf1start && $elf2end >= $elf1end)
    ) $total++;
}

echo $total;
