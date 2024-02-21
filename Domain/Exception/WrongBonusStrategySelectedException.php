<?php

namespace Domain\Exception;

use Domain\Model\BonusType;
use Symfony\Component\Uid\UuidV4;

class WrongBonusStrategySelectedException extends DomainException
{
    public static function forDepartmentWithStrategy(
        UuidV4 $id,
        BonusType $departmentBonusType,
        BonusType $strategyBonusType
    ): self {
        return new self(
            sprintf(
                'Wrong bonus strategy (%s) selected for department with id: %s and bonus type: %s.',
                $id,
                $departmentBonusType->value,
                $strategyBonusType->value
            )
        );
    }
}