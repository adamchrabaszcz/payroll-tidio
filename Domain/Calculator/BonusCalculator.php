<?php

namespace Domain\Calculator;

use Domain\Model\Employee;
use Domain\Strategy\BonusStrategySelectorInterface;

class BonusCalculator implements BonusCalculatorInterface
{
    public function __construct(
        private BonusStrategySelectorInterface $bonusStrategySelector
    ){}

    public function calculateEmployeeBonus(Employee $employee): int
    {
        $department = $employee->getDepartment();
        $bonusType = $department->getDepartmentBonus()->getBonusType();

        $bonusStrategy = $this->bonusStrategySelector->selectBonusStrategy($bonusType);

        return $bonusStrategy->calculateBonus($employee, $department);
    }
}