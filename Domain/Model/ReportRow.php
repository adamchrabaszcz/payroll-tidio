<?php

namespace Domain\Model;

use Domain\Model\Traits\BaseSalaryTrait;
use Domain\Model\Traits\FirstNameTrait;
use Domain\Model\Traits\LastNameTrait;

class ReportRow
{
    use FirstNameTrait;
    use LastNameTrait;
    use BaseSalaryTrait;

    private string $departmentName;
    private int $bonus;
    private BonusType $bonusType;
    private int $totalSalary;

    public function __construct(
        Employee $employee,
        Department $department,
        int $bonus
    ) {
        $this->firstName = $employee->getFirstName();
        $this->lastName = $employee->getLastName();
        $this->departmentName = $department->getName();
        $this->baseSalary = $employee->getBaseSalary();
        $this->bonusType = $department->getDepartmentBonus()->getBonusType();
        $this->bonus = $bonus;
        $this->totalSalary = $this->baseSalary + $this->bonus;
    }

    public function getRow(): array
    {
        return [
            'firstName' => $this->firstName,
            'lstName' => $this->lastName,
            'departmentName' => $this->departmentName,
            'baseSalary' => $this->baseSalary,
            'bonus' => $this->bonus,
            'bonusType' => $this->bonusType->value,
            'totalSalary' => $this->totalSalary
        ];
    }
}