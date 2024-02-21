<?php

namespace Domain\Model;

use Domain\Common\Traits\UuidTrait;

class Employee
{
    use UuidTrait;

    private string $firstName;
    private string $lastName;
    private \DateTimeInterface $startedWorkAt;
    private int $baseSalary;
    private Department $department;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function setDepartment(Department $department): void
    {
        $this->department = $department;
    }

    public function getStartedWorkAt(): \DateTimeInterface
    {
        return $this->startedWorkAt;
    }

    public function setStartedWorkAt(\DateTimeInterface $startedWorkAt): void
    {
        $this->startedWorkAt = $startedWorkAt;
    }

    public function getBaseSalary(): int
    {
        return $this->baseSalary;
    }

    public function setBaseSalary(int $baseSalary): void
    {
        $this->baseSalary = $baseSalary;
    }

    public function getYearsOfWork(): int
    {
        $startedWork = $this->getStartedWorkAt();
        $currentYear = new \DateTime();

        return $currentYear->diff($startedWork)->y;
    }
}