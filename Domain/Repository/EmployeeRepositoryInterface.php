<?php

namespace Domain\Repository;

use Domain\Model\Employee;
use Symfony\Component\Uid\UuidV4;

interface EmployeeRepositoryInterface
{
    public function getById(UuidV4 $id): Employee;
}