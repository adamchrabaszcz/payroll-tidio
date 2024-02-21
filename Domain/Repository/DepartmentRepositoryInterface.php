<?php

namespace Domain\Repository;

use Domain\Model\Department;
use Symfony\Component\Uid\UuidV4;

interface DepartmentRepositoryInterface
{
    public function getById(UuidV4 $id): Department;
}