<?php

namespace Domain\Model;

use Domain\Common\Traits\UuidTrait;
use Domain\Model\Traits\NameTrait;

class Department
{
    use UuidTrait;
    use NameTrait;

    /**
     * @var Employee[]
     */
    private array $employees;

    private DepartmentBonus $departmentBonus;

    public function getEmployees(): array
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): void
    {
        if (! in_array($employee, $this->employees)) {
            $this->employees[] = $employee;
        }
    }

    public function removeEmployee(Employee $employee): void
    {
        $key = array_search($employee, $this->employees, true);

        if ($key !== false) {
            unset($this->employees[$key]);
        }
    }

    public function getDepartmentBonus(): DepartmentBonus
    {
        return $this->departmentBonus;
    }

    public function setDepartmentBonus(DepartmentBonus $departmentBonus): void
    {
        $this->departmentBonus = $departmentBonus;
    }
}