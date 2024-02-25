<?php

namespace App\Manager;

use App\Entity\Department;
use App\Entity\Employee;

interface EmployeeManagerInterface
{
    public function createEmployeeFromBasicDetailsAndDepartment(
        string $firstName,
        string $lastName,
        int $baseSalary,
        \DateTimeInterface $startedWorkAt,
        Department $department
    ): Employee;
}