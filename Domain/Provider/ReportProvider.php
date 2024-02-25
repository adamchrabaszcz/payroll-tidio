<?php

namespace Domain\Provider;

use Domain\Exception\NotAllowedToFilterException;
use Domain\Factory\ReportFactoryInterface;
use Domain\Model\Report;
use Domain\Repository\EmployeeRepositoryInterface;

class ReportProvider implements ReportProviderInterface
{
    public function __construct(
        private ReportFactoryInterface $reportFactory,
        private EmployeeRepositoryInterface $employeeRepository
    ) {}

    public function provideReportForMonth(string $month, array $filterBy = [], array $sortBy = []): Report
    {
        if (isset($filterBy['field']) && ! in_array($filterBy['field'], self::FIELDS_ALLOWED_TO_FILTER)) {
            throw NotAllowedToFilterException::byFieldName($filterBy['field']);
        }

        // pre sort
        if (isset($sortBy['field']) && in_array($sortBy['field'], self::FIELDS_POST_SORTABLE)) {
            $employees = $this->employeeRepository->getAllBy($filterBy, []);
        } else {
            $employees = $this->employeeRepository->getAllBy($filterBy, $sortBy);
        }

        $report = $this->reportFactory->createReportForMonthFromEmployees($month, $employees);

        // post sort if needed
        if (isset($sortBy['field']) && in_array($sortBy['field'], self::FIELDS_POST_SORTABLE)) {
            $reportRows = $report->getReportRows();
            usort(
                $reportRows,
                function ($rowA, $rowB) use ($sortBy) {
                    if ('ASC' == $sortBy['direction']) {
                        return $rowA->getRow()[$sortBy['field']] > $rowB->getRow()[$sortBy['field']];
                    } else {
                        return $rowA->getRow()[$sortBy['field']] < $rowB->getRow()[$sortBy['field']];
                    }
                }
            );
            $report->updateReportRows($reportRows);
        }

        return $report;
    }
}