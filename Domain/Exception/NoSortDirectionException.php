<?php

namespace Domain\Exception;

class NoSortDirectionException extends DomainException
{
    public static function forFieldName(
        string $fieldName
    ): self {
        return new self(
            sprintf(
                'No sort value for field: %s.',
                $fieldName
            )
        );
    }
}