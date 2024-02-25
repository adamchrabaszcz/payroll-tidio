<?php

namespace Domain\Exception;

use Domain\Provider\ReportProviderInterface;

class NotAllowedToFilterException extends DomainException
{
    public static function byFieldName(
        string $fieldName
    ): self {
        return new self(
            sprintf(
                'Not allowed to filter by: %s. Fields allowed to filter: %s.',
                $fieldName,
                implode(',', ReportProviderInterface::FIELDS_ALLOWED_TO_FILTER),
            )
        );
    }
}