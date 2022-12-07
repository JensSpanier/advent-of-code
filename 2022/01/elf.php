<?php

class Elf
{
    private string $name;
    private array $snacks = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSnacks(): array
    {
        return $this->snacks;
    }

    public function addSnack(Snack $snack)
    {
        $this->snacks[] = $snack;
    }

    public function setSnacks(array $snacks)
    {
        $this->snacks = $snacks;
    }

    public function getTotalSnackCalories(): int
    {
        $result = 0;
        foreach ($this->getSnacks() as $snack) {
            $result += $snack->getCalories();
        }
        return $result;
    }
}
