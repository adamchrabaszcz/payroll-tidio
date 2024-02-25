<?php

namespace Domain\Factory;

use Domain\Model\Report;

interface ReportFactoryInterface
{
    public function createReportForMonthFromEmployees(
        string $month,
        array $employees
    ): Report;
}