<?php

namespace Domain\Model;

class Report
{
    private array $reportRows = [];

    public function __construct(
        private string $month
    ) {}

    public function getMonth(): string
    {
        return $this->month;
    }

    public function addReportRow(ReportRow $reportRow): void
    {
        $this->reportRows[] = $reportRow;
    }

    /**
     * @return ReportRow[]
     */
    public function getReportRows(): array
    {
        return $this->reportRows;
    }

    /**
     * @return ReportRow[]
     */
    public function updateReportRows(array $reportRows): array
    {
        $this->reportRows = $reportRows;
        return $reportRows;
    }
}