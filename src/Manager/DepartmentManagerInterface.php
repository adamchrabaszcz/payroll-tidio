<?php

namespace App\Manager;

use App\Entity\Department;
use Domain\Model\BonusType;

interface DepartmentManagerInterface
{
    public function createDepartmentFromNameAndBonus(string $name, BonusType $bonusType, int $amount): Department;
}