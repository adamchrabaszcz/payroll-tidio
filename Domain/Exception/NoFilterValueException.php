<?php

namespace Domain\Exception;

class NoFilterValueException extends DomainException
{
    public static function forFieldName(
        string $fieldName
    ): self {
        return new self(
            sprintf(
                'No filter value for field: %s.',
                $fieldName
            )
        );
    }
}