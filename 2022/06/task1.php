<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = trim($input);

//$chars = str_split($input);

for ($i = 0; $i < strlen($input); $i++) {
  if ($i >= 3) {
    $charsToCheck = [];
    for ($j = 0; $j < 14; $j++) {
      $charsToCheck[] = $input[$i - $j];
    }
    if (count($charsToCheck) === count(array_unique($charsToCheck))) {
      echo $i + 1 . PHP_EOL;
      exit;
    }
  }
}
