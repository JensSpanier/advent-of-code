<?php

require_once __DIR__ . '/elf.php';
require_once __DIR__ . '/snack.php';

$input = file_get_contents(__DIR__ . '/input.txt');
$input = trim($input) . PHP_EOL;

$lines = preg_split("/\r\n|\n|\r/", $input);

$elfs = [];
$snacks = [];
$elfCounter = 1;

foreach ($lines as $line) {
    if (empty($line)) {
        $elf = new Elf();
        $elf->setName("Elf $elfCounter");
        $elf->setSnacks($snacks);
        $elfs[] = $elf;
        $snacks = [];
        $elfCounter++;
    } else {
        $snack = new Snack();
        $snack->setCalories((int) $line);
        $snacks[] = $snack;
    }
}

// Filtering

usort($elfs, function ($a, $b) {
    return $b->getTotalSnackCalories() <=> $a->getTotalSnackCalories();
});

$total = 0;
for ($i = 0; $i < 3; $i++) {
    $total += $elfs[$i]->getTotalSnackCalories();
    echo $elfs[$i]->getName() . ' hat ' . $elfs[$i]->getTotalSnackCalories() . ' Kalorien dabei' . PHP_EOL;
}

echo "Zusammen haben die top drei Elfen $total Kalorien dabei";
