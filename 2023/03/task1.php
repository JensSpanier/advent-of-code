<?php

require_once __DIR__ . '/../../common/common.php';

$lines = getInputLines(__DIR__ . '/input.txt');
$lineLength = strlen($lines[0]);

$sum = 0;
$numbers = [];

foreach ($lines as $lineIndex => $line) {
    $combinedNumber = '';
    $startIndex = 0;

    for ($charIndex = 0; $charIndex < $lineLength; $charIndex++) {
        $char = $line[$charIndex];

        if (ctype_digit($char)) {
            if ($combinedNumber === '') {
                $startIndex = $charIndex;
            }
            $combinedNumber .= $char;
        }

        if (!ctype_digit($char) || $charIndex === ($lineLength - 1)) {
            if ($combinedNumber !== '') {
                $numbers[] = [
                    'number' => (int) $combinedNumber,
                    'lineIndex' => $lineIndex,
                    'startIndex' => $startIndex,
                    'length' => $charIndex - $startIndex,
                ];
                $combinedNumber = '';
            }
        }
    }
}

foreach ($numbers as $number) {
    if (numberAdjacentsSymbol($number)) {
        $sum += $number['number'];
    }
}

function numberAdjacentsSymbol($number)
{
    global $lines, $lineLength;
    [
        'lineIndex' => $lineIndex,
        'startIndex' => $startIndex,
        'length' => $length,
    ] = $number;

    for ($i = -1; $i <= 1; $i++) {
        $checkLineIndex = $lineIndex + $i;

        if (
            !array_key_exists($checkLineIndex, $lines)
        ) {
            continue;
        }

        $checkLine = $lines[$checkLineIndex];

        for ($j = $startIndex - 1; $j <= $startIndex + $length; $j++) {
            if (
                $j < 0 ||
                $j === $lineLength
            ) {
                continue;
            }

            $char = $checkLine[$j];

            $isSymbol = !ctype_digit($char) && $char !== '.';

            if ($isSymbol) {
                return true;
            }
        }
    }

    return false;
}

var_dump($sum);
