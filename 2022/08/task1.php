<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = trim($input);

$lines = preg_split("/\r\n|\n|\r/", $input);
$rows = [];

foreach ($lines as $line) {
  $rows[] = str_split($line);
}

$visibleTrees = [];

for ($rowKey = 0; $rowKey < count($rows); $rowKey++) {
  for ($columnKey = 0; $columnKey < count($rows[$rowKey]); $columnKey++) {
    if (
      visibleFromNorth($rows, $rowKey, $columnKey) ||
      visibleFromSouth($rows, $rowKey, $columnKey) ||
      visibleFromWest($rows, $rowKey, $columnKey) ||
      visibleFromEast($rows, $rowKey, $columnKey)
    ) {
      $visibleTrees[] = $rows[$rowKey][$columnKey];
    }
  }
}

function visibleFromNorth($rows, $rowKey, $columnKey)
{
  if ($rowKey === 0)
    return true;
  $isVisible = true;
  for ($i = 0; $i < $rowKey; $i++) {
    $isVisible = $isVisible && $rows[$i][$columnKey] < $rows[$rowKey][$columnKey];
  }
  return $isVisible;
}

function visibleFromSouth($rows, $rowKey, $columnKey)
{
  if ($rowKey === count($rows) - 1)
    return true;
  $isVisible = true;
  for ($i = $rowKey + 1; $i < count($rows); $i++) {
    $isVisible = $isVisible && $rows[$i][$columnKey] < $rows[$rowKey][$columnKey];
  }
  return $isVisible;
}

function visibleFromWest($rows, $rowKey, $columnKey)
{
  if ($columnKey === 0)
    return true;
  $isVisible = true;
  for ($i = 0; $i < $columnKey; $i++) {
    $isVisible = $isVisible && $rows[$rowKey][$i] < $rows[$rowKey][$columnKey];
  }
  return $isVisible;
}

function visibleFromEast($rows, $rowKey, $columnKey)
{
  if ($columnKey === count($rows[$rowKey]) - 1)
    return true;
  $isVisible = true;
  for ($i = $columnKey + 1; $i < count($rows[$rowKey]); $i++) {
    $isVisible = $isVisible && $rows[$rowKey][$i] < $rows[$rowKey][$columnKey];
  }
  return $isVisible;
}

echo implode(', ', $visibleTrees) . PHP_EOL;
echo count($visibleTrees) . PHP_EOL;
