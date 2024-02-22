<?php

namespace App\Doctrine\Transformer;

use Domain\Model\DepartmentBonus as Domain;
use App\Entity\DepartmentBonus as Entity;

class DepartmentBonusTransformer
{
    public function entityToDomain(Entity $entity): Domain
    {
        return new Domain($entity->getBonusType(), $entity->getAmount());
    }

    public function domainToEntity(Domain $domain): Entity
    {
        return new Entity($domain->getBonusType(), $domain->getAmount());
    }
}