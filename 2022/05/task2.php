<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = rtrim($input);

$lines = preg_split("/\r\n|\n|\r/", $input);

$stackInput = [];
$moveInput = [];

$emptyLinePassed = false;
foreach ($lines as $line) {
  if ($line === '') {
    $emptyLinePassed = true;
  } else {
    if ($emptyLinePassed) {
      $moveInput[] = $line;
    } else {
      $stackInput[] = $line;
    }
  }
}
array_pop($stackInput);

$stacks = [];
$amountStacks = (strlen($stackInput[0]) + 1) / 4;
for ($i = 0; $i < $amountStacks; $i++) {
  $stacks[$i + 1] = [];
}
$stackInput = array_reverse($stackInput);
foreach ($stackInput as $line) {
  for ($i = 0; $i < $amountStacks; $i++) {
    $letter = $line[$i * 4 + 1];
    if ($letter !== ' ') {
      $stacks[$i + 1][] = $letter;
    }
  }
}

foreach ($moveInput as $line) {
  preg_match('/move (\d+) from (\d+) to (\d+)/', $line, $matches);
  [, $amount, $from, $to] = $matches;
  $tempBoxes = [];
  for ($i = 0; $i < $amount; $i++) {
    $tempBoxes[] = array_pop($stacks[$from]);
  }
  $tempBoxes = array_reverse($tempBoxes);
  array_push($stacks[$to], ...$tempBoxes);
}

foreach ($stacks as $stack) {
  echo $stack[array_key_last($stack)];
}


echo PHP_EOL;
