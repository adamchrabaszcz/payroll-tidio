<?php

namespace App\Factory;

use App\Entity\Department;
use Domain\Model\BonusType;

interface DepartmentFactoryInterface
{
    public function createDepartmentFromNameAndBonus(string $name, BonusType $bonusType, int $amount): Department;
}