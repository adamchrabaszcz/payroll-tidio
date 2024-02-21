<?php

namespace Domain\Calculator;

use Domain\Model\Employee;

interface BonusCalculatorInterface
{
    public function calculateEmployeeBonus(Employee $employee): int;
}