<?php

namespace Domain\Repository;

use Domain\Model\Employee;

interface EmployeeRepositoryInterface
{
    /**
     * @param array $filterBy
     * @param array $sortBy
     * @return Employee[]|null
     */
    public function getAllBy(array $filterBy = [], array $sortBy = []): ?array;
}