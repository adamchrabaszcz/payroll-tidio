<?php

namespace Domain\Strategy;

use Domain\Exception\WrongBonusStrategySelectedException;
use Domain\Model\BonusType;
use Domain\Model\Department;
use Domain\Model\Employee;

abstract class AbstractBonusStrategy implements BonusStrategyInterface
{
    /**
     * @param Department $department
     * @return void
     * @throws WrongBonusStrategySelectedException
     */
    protected function validateStrategy(Department $department, BonusType $bonusType): void
    {
        if ($bonusType != $department->getDepartmentBonus()->getBonusType()) {
            throw WrongBonusStrategySelectedException::forDepartmentWithStrategy(
                $department->getId(),
                $department->getDepartmentBonus()->getBonusType(),
                $bonusType
            );
        }
    }
}