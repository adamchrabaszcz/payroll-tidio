<?php

namespace App\Manager;

use App\Entity\Department;
use App\Factory\DepartmentFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Domain\Model\BonusType;

class DepartmentManager implements DepartmentManagerInterface
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DepartmentFactoryInterface $departmentFactory
    ) {}

    public function createDepartmentFromNameAndBonus(string $name, BonusType $bonusType, int $amount): Department
    {
        $department = $this->departmentFactory->createDepartmentFromNameAndBonus($name, $bonusType, $amount);
        $this->entityManager->persist($department);
        $this->entityManager->flush();

        return $department;
    }
}