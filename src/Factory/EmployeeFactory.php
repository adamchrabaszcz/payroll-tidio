<?php

namespace App\Factory;

use App\Entity\Department;
use App\Entity\Employee;

class EmployeeFactory implements EmployeeFactoryInterface
{

    public function createEmployeeFromBasicDetailsAndDepartment(string $firstName, string $lastName, int $baseSalary, \DateTimeInterface $startedWorkAt, Department $department): Employee
    {
        $employee = new Employee();
        $employee->setFirstName($firstName);
        $employee->setLastName($lastName);
        $employee->setBaseSalary($baseSalary);
        $employee->setStartedWorkAt($startedWorkAt);
        $employee->setDepartment($department);

        return $employee;
    }
}