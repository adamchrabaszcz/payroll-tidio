<?php

namespace Domain\Strategy;

use Domain\Model\Department;
use Domain\Model\Employee;

interface BonusStrategyInterface
{
    public function calculateBonus(Employee $employee, Department $department): int;
}