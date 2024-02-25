<?php

namespace Domain\Provider;

use Domain\Exception\NotAllowedToFilterException;
use Domain\Model\Report;

interface ReportProviderInterface
{
    public const FIELDS_ALLOWED_TO_FILTER = ['firstName', 'lastName', 'departmentName'];
    public const FIELDS_PRE_SORTABLE = [...self::FIELDS_ALLOWED_TO_FILTER, ...['bonusType', 'baseSalary']];
    public const FIELDS_POST_SORTABLE = ['bonus', 'totalSalary'];
    public const FIELDS_SORTABLE = [...self::FIELDS_PRE_SORTABLE, ...self::FIELDS_POST_SORTABLE];

    /**
     * @throws NotAllowedToFilterException
     */
    public function provideReportForMonth(
        string $month,
        array $filterBy = [],
        array $sortBy = [],
    ): Report;
}