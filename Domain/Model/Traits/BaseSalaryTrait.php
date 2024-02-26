<?php

namespace Domain\Model\Traits;

trait BaseSalaryTrait
{
    private int $baseSalary;

    public function getBaseSalary(): int
    {
        return $this->baseSalary;
    }

    public function setBaseSalary(int $baseSalary): void
    {
        $this->baseSalary = $baseSalary;
    }
}