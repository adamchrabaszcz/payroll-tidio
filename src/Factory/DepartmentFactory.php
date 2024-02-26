<?php

namespace App\Factory;

use App\Entity\Department;
use App\Entity\DepartmentBonus;
use Domain\Model\BonusType;

class DepartmentFactory implements DepartmentFactoryInterface
{
    public function createDepartmentFromNameAndBonus(string $name, BonusType $bonusType, int $amount): Department
    {
        $department = new Department();
        $department->setName($name);
        $department->setDepartmentBonus(new DepartmentBonus($bonusType, $amount));

        return $department;
    }
}