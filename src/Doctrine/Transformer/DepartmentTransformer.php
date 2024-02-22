<?php

namespace App\Doctrine\Transformer;

use Domain\Model\Department as Domain;
use App\Entity\Department as Entity;

class DepartmentTransformer
{
    public function __construct(
        private DepartmentBonusTransformer $departmentBonusTransformer
    ) {}

    public function entityToDomain(Entity $entity): Domain
    {
        $domain = new Domain();
        $domain->setName($entity->getName());
        $domain->setDepartmentBonus(
            $this->departmentBonusTransformer->entityToDomain($entity->getDepartmentBonus())
        );

        return $domain;
    }

    public function domainToEntity(Domain $domain): Entity
    {
        $entity = new Entity();
        $entity->setName($domain->getName());
        $entity->setDepartmentBonus(
            $this->departmentBonusTransformer->domainToEntity($domain->getDepartmentBonus())
        );

        return $entity;
    }
}