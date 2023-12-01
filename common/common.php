<?php

function getInputLines(string $inputFile): array
{
    $input = file_get_contents($inputFile);
    $input = trim($input);

    $lines = preg_split("/\r\n|\n|\r/", $input);
    return $lines;
}
