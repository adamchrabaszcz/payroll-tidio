<?php

namespace App\Doctrine\Transformer;

use Domain\Model\Employee as Domain;
use App\Entity\Employee as Entity;

class EmployeeTransformer
{
    public function __construct(
        private DepartmentTransformer $departmentTransformer
    ) {}

    public function entityToDomain(Entity $entity): Domain
    {
        $domain = new Domain();
        $domain->setFirstName($entity->getFirstName());
        $domain->setLastName($entity->getLastName());
        $domain->setStartedWorkAt($entity->getStartedWorkAt());
        $domain->setBaseSalary($entity->getBaseSalary());
        $domain->setDepartment(
            $this->departmentTransformer->entityToDomain($entity->getDepartment())
        );

        return $domain;
    }

    public function domainToEntity(Domain $domain): Entity
    {
        $entity = new Entity();
        $entity->setFirstName($domain->getFirstName());
        $entity->setLastName($domain->getLastName());
        $entity->setStartedWorkAt($domain->getStartedWorkAt());
        $entity->setBaseSalary($domain->getBaseSalary());
        $entity->setDepartment(
            $this->departmentTransformer->domainToEntity($domain->getDepartment())
        );

        return $entity;
    }
}