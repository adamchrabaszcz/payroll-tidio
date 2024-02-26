<?php

namespace App\Manager;

use App\Entity\Department;
use App\Entity\Employee;
use App\Factory\EmployeeFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeManager implements EmployeeManagerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EmployeeFactoryInterface $employeeFactory
    ) {}

    public function createEmployeeFromBasicDetailsAndDepartment(string $firstName, string $lastName, int $baseSalary, \DateTimeInterface $startedWorkAt, Department $department): Employee
    {
        $employee = $this->employeeFactory->createEmployeeFromBasicDetailsAndDepartment(
            $firstName,
            $lastName,
            $baseSalary,
            $startedWorkAt,
            $department
        );

        $this->entityManager->persist($employee);
        $this->entityManager->flush();

        return $employee;
    }
}