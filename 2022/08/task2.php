<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = trim($input);

$lines = preg_split("/\r\n|\n|\r/", $input);
$rows = [];

foreach ($lines as $line) {
  $rows[] = str_split($line);
}

$viewScores = [];

for ($rowKey = 0; $rowKey < count($rows); $rowKey++) {
  for ($columnKey = 0; $columnKey < count($rows[$rowKey]); $columnKey++) {
    $northView = getNorthView($rows, $rowKey, $columnKey);
    $southView = getSouthView($rows, $rowKey, $columnKey);
    $westView = getWestView($rows, $rowKey, $columnKey);
    $eastView = getEastView($rows, $rowKey, $columnKey);
    $viewScores[] = $northView * $southView * $westView * $eastView;
  }
}

echo max($viewScores) . PHP_EOL;

function getNorthView($rows, $rowKey, $columnKey)
{
  if ($rowKey === 0)
    return 0;
  $treeCounter = 0;
  for ($i = $rowKey - 1; $i >= 0; $i--) {
    $treeCounter++;
    if ($rows[$i][$columnKey] >= $rows[$rowKey][$columnKey])
      return $treeCounter;
  }
  return $treeCounter;
}

function getSouthView($rows, $rowKey, $columnKey)
{
  if ($rowKey === count($rows) - 1)
    return 0;
  $treeCounter = 0;
  for ($i = $rowKey + 1; $i < count($rows); $i++) {
    $treeCounter++;
    if ($rows[$i][$columnKey] >= $rows[$rowKey][$columnKey])
      return $treeCounter;
  }
  return $treeCounter;
}

function getWestView($rows, $rowKey, $columnKey)
{
  if ($columnKey === 0)
    return 0;
  $treeCounter = 0;
  for ($i = $columnKey - 1; $i >= 0; $i--) {
    $treeCounter++;
    if ($rows[$rowKey][$i] >= $rows[$rowKey][$columnKey])
      return $treeCounter;
  }
  return $treeCounter;
}

function getEastView($rows, $rowKey, $columnKey)
{
  if ($columnKey === count($rows[$rowKey]) - 1)
    return 0;
  $treeCounter = 0;
  for ($i = $columnKey + 1; $i < count($rows[$rowKey]); $i++) {
    $treeCounter++;
    if ($rows[$rowKey][$i] >= $rows[$rowKey][$columnKey])
      return $treeCounter;
  }
  return $treeCounter;
}
