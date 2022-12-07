<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = trim($input);

$lines = preg_split("/\r\n|\n|\r/", $input);

$filesystem = [];
$currentLocation = [];

foreach ($lines as $line) {
  if (preg_match('/\$ cd (.+)/', $line, $matches)) {
    if ($matches[1] === '/') {
      $currentLocation = [];
    } elseif ($matches[1] === '..') {
      array_pop($currentLocation);
    } else {
      $currentLocation[] = $matches[1];
    }
  } elseif (preg_match('/dir (.+)/', $line, $matches)) {
    $filesystemPart = &getCurrentLocation();
    $filesystemPart[$matches[1]] = [];
  } elseif (preg_match('/(\d+) (.+)/', $line, $matches)) {
    $filesystemPart = &getCurrentLocation();
    $filesystemPart[$matches[2]] = (int) $matches[1];
  }
}

$totalUnderLimit = 0;
getTotalFolderSize($filesystem);
echo $totalUnderLimit . PHP_EOL;


function getTotalFolderSize($folder)
{
  global $totalUnderLimit;
  $totalSize = 0;
  foreach ($folder as $subfolder) {
    $totalSize += is_array($subfolder) ? getTotalFolderSize($subfolder) : $subfolder;
  }
  if ($totalSize <= 100000) {
    $totalUnderLimit += $totalSize;
    echo $totalSize . PHP_EOL;
  }
  return $totalSize;
}

function &getCurrentLocation()
{
  global $filesystem, $currentLocation;
  $tempLocation = &$filesystem;
  foreach ($currentLocation as $currentLocationPart) {
    $tempLocation = &$tempLocation[$currentLocationPart];
  }
  return $tempLocation;
}
