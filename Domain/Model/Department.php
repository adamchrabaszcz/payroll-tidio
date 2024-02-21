<?php

namespace Domain\Model;

use Domain\Common\Traits\UuidTrait;

class Department
{
    use UuidTrait;

    private string $name;

    /**
     * @var Employee[]
     */
    private array $employees;

    private DepartmentBonus $departmentBonus;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

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