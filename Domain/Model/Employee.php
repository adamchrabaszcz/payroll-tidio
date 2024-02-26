<?php

namespace Domain\Model;

use Domain\Common\Traits\UuidTrait;
use Domain\Model\Traits\BaseSalaryTrait;
use Domain\Model\Traits\FirstNameTrait;
use Domain\Model\Traits\LastNameTrait;

class Employee
{
    use UuidTrait;
    use FirstNameTrait;
    use LastNameTrait;
    use BaseSalaryTrait;

    private \DateTimeInterface $startedWorkAt;
    private Department $department;

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

    public function getYearsOfWork(): int
    {
        $startedWork = $this->getStartedWorkAt();
        $currentYear = new \DateTime();

        return $currentYear->diff($startedWork)->y;
    }
}