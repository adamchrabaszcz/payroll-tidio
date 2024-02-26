<?php

namespace App\Factory;

use App\Entity\Department;
use App\Entity\Employee;

interface EmployeeFactoryInterface
{
    public function createEmployeeFromBasicDetailsAndDepartment(
        string $firstName,
        string $lastName,
        int $baseSalary,
        \DateTimeInterface $startedWorkAt,
        Department $department
    ): Employee;
}