<?php

namespace Domain\Factory;

use Domain\Calculator\BonusCalculatorInterface;
use Domain\Model\Report;
use Domain\Model\ReportRow;
use Domain\Repository\EmployeeRepositoryInterface;

class ReportFactory implements ReportFactoryInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository,
        private BonusCalculatorInterface $bonusCalculator
    ) {}

    public function createReportForMonthFromEmployees(
        string $month,
        array $employees
    ): Report {
        $report = new Report($month);

        foreach ($employees as $employee) {
            $report->addReportRow(
                new ReportRow($employee, $employee->getDepartment(), $this->bonusCalculator->calculateEmployeeBonus($employee))
            );
        }

        return $report;
    }
}