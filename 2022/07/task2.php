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

$folderSizes = [];
$updateSize = 30000000;
$diskSize = 70000000;
$totalSize = getTotalFolderSize($filesystem);
$needToFree = - ($diskSize - $totalSize - $updateSize);
$currentDeleteSize = max($folderSizes);
foreach ($folderSizes as $folderSize) {
  if ($folderSize >= $needToFree && $folderSize < $currentDeleteSize)
    $currentDeleteSize = $folderSize;
}

echo $currentDeleteSize . PHP_EOL;

function getTotalFolderSize($folder)
{
  global $folderSizes;
  $totalSize = 0;
  foreach ($folder as $subfolder) {
    $totalSize += is_array($subfolder) ? getTotalFolderSize($subfolder) : $subfolder;
  }
  $folderSizes[] = $totalSize;
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
