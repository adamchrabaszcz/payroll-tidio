<?php

namespace Domain\Strategy;

use Domain\Exception\WrongBonusStrategySelectedException;
use Domain\Model\BonusType;
use Domain\Model\Department;
use Domain\Model\Employee;

class PercentageBonusStrategy extends AbstractBonusStrategy
{

    /**
     * @throws WrongBonusStrategySelectedException
     */
    public function calculateBonus(Employee $employee, Department $department): int
    {
        $this->validateStrategy($department, BonusType::PERCENTAGE);

        return $employee->getYearsOfWork() > 0
            ? max($department->getDepartmentBonus()->getAmount() * $employee->getBaseSalary() / 100, 0)
            : 0;
    }
}