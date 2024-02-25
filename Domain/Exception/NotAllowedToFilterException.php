<?php

namespace Domain\Exception;

use Domain\Factory\ReportFactoryInterface;

class NotAllowedToFilterException extends DomainException
{
    public static function byFieldName(
        string $fieldName
    ): self {
        return new self(
            sprintf(
                'Not allowed to filter by: %s. Fields allowed to filter: %s.',
                $fieldName,
                implode(',', ReportFactoryInterface::FIELDS_ALLOWED_TO_FILTER),
            )
        );
    }
}