<?php

namespace Domain\Strategy;

use Domain\Exception\WrongBonusStrategySelectedException;
use Domain\Model\BonusType;
use Domain\Model\Department;
use Domain\Model\Employee;

class FixedAmountBonusStrategy extends AbstractBonusStrategy
{
    private const YEAR_CAP = 10;

    /**
     * @throws WrongBonusStrategySelectedException
     */
    public function calculateBonus(Employee $employee, Department $department): int
    {
        $this->validateStrategy($department, BonusType::FIXED);

        return max(
            $department->getDepartmentBonus()->getAmount() * min($employee->getYearsOfWork(), self::YEAR_CAP),
            0
        );
    }
}